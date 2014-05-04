/**
 * Created by zhaoxun321 on 2/05/2014.
 */
$(document).ready(function(){
    $('.imagepath').hide();
    $('#buttonsubmit').hide();
    $('#loadingzone').hide();
    $('#pre-faceAnalysis').hide();
    /**
     * Image uploading
     */

    $('body').on('click','#photouploadinput',function(){
        $("input[name='uploadfile']").change(function(e){
            var file = $("#photouploadinput")[0].files[0];
            $in=$(this);
            if($in.val()!=''){
                $('#fileuploadfield').fadeOut(200,function(){
                    //wipe old img off
                    $('#image_zone').fadeOut(500,function(){$(this).attr('src','assets/img/loading.gif').fadeIn(500);
                        $('#buttonsubmit').addClass('animated bounceInDown').fadeIn();
                        $('.imagepath').text($in.val() + ' ( '+ file.name+', '+ file.size+' bytes FileType: ' +file.type +' )').fadeIn(1000);
                        ajaxFileUpload();
                    });


                });
            }

        });

    });

    //function of ajaxFileUpload()
    function ajaxFileUpload()
    {
        try{
            $.ajaxFileUpload
            (
                {
                    url:'/model/img.model.php',
                    secureuri:false,
                    fileElementId:'photouploadinput',
                    dataType: 'json',
                    success: function (data)
                    {   console.log(data);
                        if(data.success==1){
                            //success
                            $('#image_zone').fadeOut(1000,function(){$(this).attr('src',data.imagepath).fadeIn(1000);
                                $('.imagepath').empty().text('File bytes: '+data.imgtype+',  FileType: '+ data.imgsize+' , path: ' +data.imagepath);
                                $('#buttonsubmit').removeClass('disabled');

                            });

                        }
                        else if(data.success==0){
                            alert(data)
                        }


                    }
                }
            )
            return false;

        }catch(err){
            alert(err);
        }

    }



    //click #buttonsubmit to do analysis
    $('body').on('click','#buttonsubmit',function(){
        if($(this).hasClass('disabled')){
            //if current user did not upload the photo
            alert('you have to choose the photo to upload!');
        }
        else{
            //prepare to do analysis
            var width = $('#uploadSection').width();
            var height = $('#uploadSection').height();
            $('#loadingzone').css('width',width+'px');
            $('#loadingzone').css('height',height+'px');
            $('#loadingzone').css('padding-top','25%');

            $('#uploadSection').addClass('animated bounceOutLeft').fadeOut(500,function(){
                $('#loadingzone').addClass('animated bounceInRight').append('<i style="color:#008CBA" class="fa fa-5x fa-cog fa-spin"></i>').fadeIn();
                sendToAnalysis('/model/facePlus.model.php',{acid:'0',anysislyurl:$('#image_zone').attr('src')},'html');

            });

        }

    });




    //analysis function
    function sendToAnalysis(url,data,datatype,successfunction){
        var request = $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: datatype
        });

        request.done(function( data ) {

            if(data!=''){
                    $('#loadingzone').addClass('animated bounceOutLeft').fadeOut(500,function(){
                    $('#pre-faceAnalysis').addClass('animated bounceInRight').fadeIn().append(data);

                    });





            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }


    /**
     * end
     */







});