/**
 * This js file will controll the functionality of hijackme
 */

$(document).ready(function(){

    /**
     * gobal variables
     */
       window.photoidCollector = [];

    /**
     * end
     */


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
                    url:'/controller/img.controller.php',
                    secureuri:false,
                    fileElementId:'photouploadinput',
                    dataType: 'json',
                    success: function (data)
                    {
                        if(data.success==1){
                            //success
                            console.log(data);
                            $('#image_zone').fadeOut(1000,function(){$(this).attr('src',data.imagePathWithResizeUrl).fadeIn(1000);
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
                sendToAnalysis('/controller/face.controller.php',{imgjson:imgjson,anysislyurl:$('#image_zone').attr('src')},'json');

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
            //if data obtain unsuccessed

            if(data.success==0){
                $('#loadingzone').addClass('animated bounceOutDown').fadeOut(500,function(){
                    $('#Common_modal').append('<a class="close-reveal-modal close-reveal-modal-upload">&#215;</a><div data-alert="" class="alert-box alert">It seems your photo does not contain any person, please upload another one.</div>');
                });

            }
            else if(data.success==1){
                //get page facepair.html and then append to div of #loadingzone
                $.get("facepair.html", function(getdata){
                    $('#loadingzone').addClass('animated bounceOutLeft').fadeOut(500,function(){

                        $('#pre-faceAnalysis').append(getdata);
                        //execute face information insert operation
                        CurrentFaceInfoToInsert(data.currentFaceInfo[0]);
                        preQueryMatchedResult(data.currentFaceInfo[0]);
                        $('#pre-faceAnalysis').addClass('animated bounceInRight').fadeIn();


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


    /**
     * Face base info insert
     */
    function CurrentFaceInfoToInsert(getCurrentValue){
        console.log(getCurrentValue);
        var getCurrentAge = getCurrentValue.Age;
        var getCurrentAgeRange = getCurrentValue.Age_range;
        var getCurrentGender = getCurrentValue.Gender;
        var getCurrentGlass = getCurrentValue.Glass;
        var getCurrentRace =  getCurrentValue.Race;
        var getCurrentSmiling= getCurrentValue.Smiling;
        var getCurrentPitch_angle = getCurrentValue.Pitch_angle;
        var getCurrentRoll_angle = getCurrentValue.Roll_angle;
        var getCurrentYaw_angle = getCurrentValue.Yaw_angle;
        var getCurrentLandmark = getCurrentValue.Landmark;
        var getCurrentImgID = getCurrentValue.ImgID;
        var getCurrentImagePath =getCurrentValue.ImgPathWithResizeUrl;
        var getCurrentImgDate =getCurrentValue.ImgDate;
        var getCurrentLongitude =getCurrentValue.Longitude;
        var getCurrentLatitude =getCurrentValue.Latitude;
        //update #faceAnalysisResult first, call function
        updateCurrentImage(getCurrentImgID,getCurrentImagePath);
        //update location
        updateFaceAnalysisResult(getCurrentAge,getCurrentAgeRange,getCurrentGender,getCurrentGlass,getCurrentRace,getCurrentSmiling,returnLoction(getCurrentLongitude,getCurrentLatitude));


    }

    /**
     * end
     */


    /**
     *
     * update the image zone
     */

    function updateCurrentImage(getCurrentImgID,getCurrentImagePath){
        $('.image_zone').attr('src',getCurrentImagePath);
        $('.image_zone').attr('id',getCurrentImgID);

    }


    /**
     * end
     */






    /**
     *  update  #faceAnalysisResult
     * @param getCurrentAge
     * @param getCurrentAgeRange
     * @param getCurrentGender
     * @param getCurrentGlass
     * @param getCurrentRace
     * @param getCurrentSmiling
     * @param getGeolocation
     */
    function updateFaceAnalysisResult(getCurrentAge,getCurrentAgeRange,getCurrentGender,getCurrentGlass,getCurrentRace,getCurrentSmiling,getGeolocation){
        if($('#faceAnalysisResult').length>0){
            $('#faceAnalysisResult').append('<ul class="inline-list">');
            $('#faceAnalysisResult').append('<span class="radius secondary  label">Age:'+getCurrentAge+' (The range may be around ['+getCurrentAgeRange+'])</span>');
            $('#faceAnalysisResult').append('<span class="radius secondary pairlist label">Glass:'+getCurrentGlass+'</span>');
            $('#faceAnalysisResult').append('<span class="radius secondary pairlist label">Race:'+getCurrentRace+'</span');
            $('#faceAnalysisResult').append('<span class="radius secondary pairlist label">Smiling: posibility ('+getCurrentSmiling+')</span>');
            $('#faceAnalysisResult').append('<span class="radius secondary pairlist label">Location:'+getGeolocation+'</span>');
            $('#faceAnalysisResult').append('</ul>');

        }




    }



    /**
     * end
     */


    /**
     * return the location
     */

    function returnLoction(getCurrentLongitude,getCurrentLatitude){
        if(getCurrentLongitude!=null && getCurrentLatitude!=null){
            //pass coording to check the location
            return googleMapLocationApI(getCurrentLongitude,getCurrentLatitude);
        }
        else{
            return 'None';
        }

    }


    /**
     * end
     */










    /**
     * google map location api
     */


    function googleMapLocationApI(getCurrentLongitude,getCurrentLatitude){







    }



    /**
     * end
     */






    /**
     * query and insert matched photo
     */

    function preQueryMatchedResult(result){
        $('#MatchedZone').append('<i style="color:#e74c3c" id="matchedPhotoloading" class="animated bounceln fa fa-refresh fa-spin fa-2x"></i>');

        var request = $.ajax({
            url: "/controller/match.controller.php",
            type: "POST",
            data: {'FacePlusID':result.FacePlusID},
            dataType: "json"
        });

        request.done(function( data ) {
            $('#matchedPhotoloading').addClass('animated fadeOut').fadeOut(500,function(){

                if(data.number>0){
                    inertMatchedResult(data.result);
                }
                else if(data.number==0){
                    $('#MatchedZone').append('<div data-alert="" class="alert-box alert round">It looks like this is your first photo, Please input your name for it<a href="#" class="close">×</a></div>');
                    $('#MatchedZone').append('<div class="row"><div class="large-12 columns"><form><div class="row"><div class="large-4 columns animated fadeInUp" style="left:16px"><input type="text" placeholder="Your name, ie. john" /></div><div class="large-1 columns end"><span class="postfix radius" id="addedName">Add</span></div></div></form></div></div>');

                }

            });






        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });



    }


    function inertMatchedResult(result){
        console.log(result);
        $('#MatchedZone').append('<div class="row"><div class="large-12 columns"><ul id="matchedPhotoThumbs" style="padding:19px" class="small-block-grid-2 medium-block-grid-3 large-block-grid-4"></ul></div></div>');
        $.each(result,function(key,value){

            $('#matchedPhotoThumbs').append('<li class="animated gridphotolist rollIn" style="position:relative"><img class="th" src="'+value.ImgPathWithResizeUrl+'"><div class="graidphoto"><div class="row"><div class="small-6 large-6 columns selectzone"><a class="tiny button radius graidphotoButton">Detail</a> </div> <div class="small-6 large-6 columns"> <a id="'+value.value+'" class="clickedSelect tiny button radius graidphotoButton">Select</a></div></div></div></li>');
        });


   }





    function requestToCreatePerson(){



    }


    /**
     * end
     */


    /**
     * select to add into photo containter
     */

        $('body').on('click','.clickedSelect',function(){
            var getcurrentThis = $(this);
            var getCurrentPhotoID = $(this).attr('id');
            var getParrent = $(this).parent()
            photoidCollector.push(getCurrentPhotoID);
            //hide current button and added tick
            $(getParrent).fadeOut(500,function(){
                $(getcurrentThis).remove();
                $(this).append('<i class="fa fa-check"></i>').fadeIn();

            });

            console.log(photoidCollector);
        });
    /**
     * end
     */


});



$(window).ready(function(){
    $('#logo').addClass('animated rotateInDownLeft').fadeIn(500,function(){
        $('#beginsShow').addClass('animated bounceIn').fadeIn(500,function(){
            $('.has-tip').addClass('animated fadeInUp').fadeIn();
        });


    });







});
