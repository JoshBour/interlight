$(function () {
    var body = $('body');
    var flash = $('#flash');
    var focusedDiv;
    if (flash.is(':visible')) {
        flash.setRemoveTimeout(3000);
    }
    var gt = new Gettext({ 'domain': 'messages' });

    $('.printTrigger').on('click',function(e){
        e.preventDefault();
        window.print();
    });

    /* ===================================================== */
    /*                       Tab Related                     */
        var tabs = $('.tabs span');

        tabs.each(function(){
            var span = $(this);
            var id = span.attr('class').split(' ')[0].substr(4);
            if(span.hasClass('activeTab')){
                $('#'+id).show();
            }else{
                $('#'+id).hide();
            }
        });

        tabs.on('click',function(){
           var span = $(this);
            if(!span.hasClass('activeTab')){
                var activeTab = span.siblings('.activeTab').removeClass('activeTab');
                $('#'+activeTab.attr('class').split(' ')[0].substr(4)).fadeOut("normal",function(){
                    $('#'+span.attr('class').split(' ')[0].substr(4)).fadeIn();
                });
                span.addClass('activeTab');
            }
        });

    /* ===================================================== */
    /*                   Slide Show Related                  */

        var slideShowInterval = null;

        function slideShowIntervalManager(flag) {
            if (flag)
                slideShowInterval = setInterval(function () {
                    $('#slideShowPics').find('.slide:first').fadeOut("slow", function () {
                        $(this).next('.slide').fadeIn("slow").end().appendTo('#slideShowPics');
                    });
                }, 7000);
            else
                clearInterval(slideShowInterval);
        }
        slideShowIntervalManager(true);

        $('#slideShowPics').find('.slide:gt(0)').hide();

        $('span[class$="Toggle"]').on('click', function () {
            resetActiveField();
            var toggler = $(this).attr('class');
            var element = $('#' + toggler.substr(0, toggler.length - 6));
            if (element.is(':visible')) {
                resetActiveField();
                element.slideToggle("normal", function () {
                    ofh = new $.fn.dataTable.FixedHeader(table);
                });
            } else {
                element.slideToggle();
                body.children(".fixedHeader").each(function () {
                    $(this).remove();
                });
            }
        });

        $('#slideLeft').on('click', function () {
            slideShowIntervalManager(false);
            $('#slideShowPics').find('.slide:first').fadeOut("slow", function () {
                $(this).siblings('.slide:last-of-type').fadeIn("slow").prependTo('#slideShowPics');
            });
            slideShowIntervalManager(true);
        });

        $('#slideRight').on('click', function () {
            slideShowIntervalManager(false);
            $('#slideShowPics').find('.slide:first').fadeOut("slow", function () {
                $(this).next('.slide').fadeIn("slow").end().appendTo('#slideShowPics');
            });
            slideShowIntervalManager(true);
        });

    /* ===================================================== */
    /*                 Product Category Search               */

        /**
         * @description The category search function.
         */
        var isSearching = false;
        var categories = $('#categories').html();
        $(".search input").on('keyup', function (event) {
            var value = $(this).val().trim().toLowerCase();
            delay(function () {
                event.preventDefault();
                if (!isSearching) {
                    isSearching = true;
                    var resultList = $('#categories');
                    if (value.length == 0) {
                        resultList.html(categories);
                    } else if (value.length > 1) {
                        $.ajax({
                            url: baseUrl + '/products/search/' + value,
                            type: "GET"
                        }).success(function (data) {
                            if ($.trim(data) != "") {
                                resultList.html(data);
                            }
                        }).error(function () {
                            addMessage(gt.gettext("Something with wrong, please try again."));
                        });
                    }
                    isSearching = false;
                }
            }, 150);
        });

    /* ===================================================== */
    /*                   Product View Page                   */

    if(body.hasClass('productPage')){
//                var productImg = $('.productThumbnail');
//                var productImgPadding = (Math.floor($('.heightAdjuster').outerHeight(true)/2)-parseInt(productImg.css('height'))/2)-1;
//                console.log(productImg.css('height'));
//                productImg.css(
//                    'padding',  productImgPadding + 'px 15px'
//                );
//
//                if($('#relatedProducts').length >0){
//                    $('#datasheet .moduleBody').css('padding', (Math.floor($('#relatedProducts').outerHeight()-26)/2)-6 + "px 0");
//                }else{
//                 //   $('#datasheet').css('width','798px');
//                }

        $('.productAttributes tbody tr').on('click',function(){
            window.location = $(this).next('tr.productMeta').find('a').attr('href');
        });
    }
});