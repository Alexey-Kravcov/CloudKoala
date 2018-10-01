jQuery(document).ready(function(){

    var $ = jQuery;
    var count

    $('.fancybox').fancybox();

    $('#tabs').tabs();

    $( ".datepicker" ).datepicker({
        dateFormat: "dd-mm-yy",
        firstDay: 1,
    });

    if($('#v-editor').size() > 0) {
        CKEDITOR.replace('v-editor');
    }
    if($('.html-text').size() > 0) {
        CKEDITOR.replaceAll('html-text');
    }

    $('.source-translit').keyup(function(){
        //translit('#productproperty-name', '#productproperty-code');
        if($('.source-translit').size() > 0) {
            //console.log('translit!')
            translit('.source-translit', '.target-translit');
        }

        return false;
    });

    $( "#sortable-target, #sortable-source" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();

// изменение ролей пользователей
    $('.profile-index .roles-list select').on('change', function(){
        var role = $(this).val();
        var user = $(this).parent().find('input[name=username]').val();
        var data = 'role='+ role +'&username='+ user;
        $.ajax({
            url: 'roles',
            type: 'post',
            data: data,
            success: function (respond) {
                //alert(respond);
            }
        })
    })

//изменение прав ролей
    $('.profile-index .permission-list input[type=checkbox]').on('change', function() {
        var perm = $(this).attr('name');
        var action;
        if ($(this).val() > 0) {
            $(this).val(0);
            action = 0;
        } else {
            $(this).val(1);
            action = 1;
        }
        var role = $(this).closest('.permission-list').find('input[name=rolename]').val();
        var data = 'perm='+perm+'&role='+role+ '&set='+ action;
        var row = $(this).closest('.row').find('.condition');
        $.ajax({
            url: 'permissions',
            type: 'post',
            data: data,
            success: function (respond) {
                row.html(respond);
                setTimeout(function(){
                    row.html('');
                }, 2000);
            }
        })
    })

    // кнопка поиска элемента в свойстве
    $('.property-input .add-element-button').on('click', function() {
        $(this).closest('.property-input').find('input').addClass('searching');
        $.ajax({
            url: 'http://yii/shop/backend/web/product-ajax/',
            type: 'post',
            data: '',
            success: function(res) {
                $('#find-element-form').html(res);
            }
        })
    })

    //кнопка Применить
    $('.apply-button').on('click', function() {
        $('input[name=apply]').val(1);
        $(this).html('<img src="'+ webAlias +'/images/loading.gif" />');
        $(this).closest('form').submit();
    })

    //выбор типа свойства
    $('form select.property-type-select').on('change', function(){
        var val = $(this).val();
        $('.property-advance').each(function(ind, obj) {
            $(obj).removeClass('show');
        })
        if(val == 'L') {
            $('#list-fields').addClass('show');
        }
        if(val == 'LS' || val == 'LE') {
            $('#link-setting').addClass('show');
        }
    })

    //кнопка добавлнеия вариантов списка
    $('#more-enum-button').on('click', function(){
        var num = $('#list-fields input[name=rows-count]').val();
        num++;
        $('#list-fields input[name=rows-count]').val(num);
        var row = "<div class='row'> <input type='hidden' name='"+ name +"'[id]' value='0' /> <div class='col-md-3'> <input type='text' name='"+ num +"[code]' class='number-input' /> </div> <div class='col-md-6'> <input type='text' name='"+ num +"[name]' class='text-input' /> </div> <div class='col-md-3 center'> <input type='checkbox' name='"+ num +"[by_default]' value='1' /> </div> </div>";
        $('#list-row-data').append(row);
        return false;
    })

    //переключения значения по умолчанию
    $('#list-fields input[type=checkbox]').on('click', function(){
        if($(this).hasClass('active')) return true;
         else {
            $('#list-fields input[type=checkbox]').each(function (ind, obj) {
                $(obj).removeClass('active').removeAttr('checked');
            })
            $(this).addClass('active').attr('checked');
            return true;
        }
    })

    //загрузка списка ячеек для LS
    $('.cell-type-select').on('change', function(){
        var typeID = $(this).val();
        var data = 'type_id='+ typeID;
        $.ajax({
            url: webAlias+ '/cell-ajax/property-items-select/',
            type: 'post',
            data: data,
            success: function (respond) {
                if(respond) {
                    $('#cell-item-container').html(respond);
                    $('#cell-section-container').html('');
                }
            }
        })
    })

    //загрузка списка ячеек для LE
    $('#cell-item-container').on('change', '.cell-item-select', function(){
        var itemID = $(this).val();
        var data = 'item_id='+ itemID;//alert(data);
        $.ajax({
            url: webAlias+ '/cell-ajax/property-sections-select/',
            type: 'post',
            data: data,
            success: function (respond) {
                if(respond) {
                    $('#cell-section-container').html(respond);
                }
            }
        })
    })

    //отправка данных формы состава меню
    $('.menu-form-container form').on('submit', function(){
        $(this).find('.source-menu input').each(function(ind, obj){
            $(obj).remove();
        })
        return true;
    })

    //навигация в модуле Cell
    $('.cell-edit-content .navigation-tree .navigation-item .nav-icon').on('click', function(){
        var item = $(this).closest('.navigation-item');
        item.toggleClass('open');
        if(item.hasClass('open')) {
            var sub = item.find('.sublevel').eq(0);
            if (item.find('.sublevel').eq(0).size() > 0) {
                var h = parseInt(sub.outerHeight());
                sub.css('height','0px');
                sub.height(h);
            }
            if(!item.hasClass('loaded')) {
                var typeID = item.find('input[name=type-id]').val();
                var mode = item.find('input[name=mode]').val();
                sub.html('<span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span>');
                getAjaxCellSections(typeID, mode, sub);
                item.addClass('loaded');
            }
        } else {
            item.find('.sublevel').eq(0).removeAttr('style');
        }
    })

    function getAjaxCellSections(typeID, mode, sub) {
        var data = 'type_id='+ typeID +'&mode='+ mode;
        $.ajax({
            url: webAlias+ '/cell-ajax/get-cell-items/',
            type: 'post',
            data: data,
            success: function (respond) {
                sub.html(respond);
                var h0 = parseInt(sub.outerHeight());
                sub.removeAttr('style');
                var h = parseInt(sub.outerHeight());
                sub.css('height', h0 +'px');
                sub.height(h);
            }
        })
    }

    //добавление поля для параметра компонента
    $('.component-list-form .params-block .add-params').on('click', function(){
        console.log('!!!');
        var item = $(this).closest('.params-block').find('.params-list .param-item:last').clone();
        item.find('input').val('');
        $('.component-list-form .params-block .params-list').append(item);
        return false;
    })

})

