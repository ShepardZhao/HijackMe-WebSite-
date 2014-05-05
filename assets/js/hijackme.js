/**
 * This js file will controll the functionality of hijackme
 */
//define the variable
$(document).ready(function(){
    /**
     * fundation reveal configuration
     */
    Foundation.libs.reveal.settings.close_on_background_click = false;
    $(document).foundation();
    /**
     * end
     */




    /**
     * end
     */





    /**
     * Image uploading
     */

    $('body').on('click','#photouploadinput',function(){
        $('body').on("change","input[name='uploadfile']",function(e){
            var file = $("#photouploadinput")[0].files[0];
            $in=$(this);
            if($in.val()!=''){
                $('#fileuploadfield').fadeOut(200,function(){
                    //wipe old img off
                    $('#image_zone').fadeOut(500,function(){$(this).attr('src','assets/img/loading.gif').fadeIn(500);
                        $('#buttonsubmit').text('uploading').addClass('animated bounceInDown').fadeIn();
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
                                $('#buttonsubmit').text('Analyse').removeClass('disabled');
                                window.imgjson = data;
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
    $(document).on('click','#buttonsubmit',function(){
        if($(this).hasClass('disabled')){
            //if current user did not upload the photo
            alert('you have to choose the photo to upload!');
        }
        else{
            //prepare to do analysis

            $('#uploadSection').addClass('animated bounceOutLeft').fadeOut(500,function(){
                $('#loadingzone').addClass('animated bounceInRight').append('<i style="color:#008CBA" class="fa fa-5x fa-cog fa-spin"></i>').fadeIn();
                //passing the data
                sendToAnalysis('/model/facePlus.model.php',{imgjson:imgjson,anysislyurl:$('#image_zone').attr('src')},'json');

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
            console.log(data);
            //if data obtain unsuccessed
            if(data.success==0){
                alert('error');

            }
            else if(data.success==1){
                $('#loadingzone').addClass('animated bounceOutLeft').fadeOut(500,function(){
                    $.get("photoStore.php", function(getdata){
                        $('#pre-faceAnalysis').addClass('animated bounceInRight').fadeIn().append(getdata);
                    });




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


