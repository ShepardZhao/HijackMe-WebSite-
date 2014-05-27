/**
 * This js file will controll the functionality of hijackme
 */
$('body').hide();

$(window).load(function(){
    window.getImageID= new Array();
    $(".fancybox").fancybox();

    $('body').show();
    //portal

    $('#portal1').addClass('animated flipInY').fadeIn(500,function(){
        $('#portal2').addClass('animated flipInY').fadeIn(500,function(){
            $('#portal3').addClass('animated flipInY').fadeIn(500,function(){

            });
        });

    });


    //index
    $('#logo').addClass('animated rotateInDownLeft').fadeIn(500,function(){
        $('#beginsShow').addClass('animated bounceIn').fadeIn(500,function(){
            $('.has-tip').addClass('animated fadeInUp').fadeIn(500,function(){
            });
        });
    });



    /************************************ Login part *************************************/

    $('body').on('click','#click_SignIn',function(){
       var getLoginEmail = $('#loginEmail').val();
       var getLoginPassword = $('#loginPassword').val();

        var request = $.ajax({
            url: 'controller/login.controller.php',
            type: "POST",
            data: {'loginEmail':getLoginEmail,'LoginPassword':getLoginPassword},
            dataType: 'json'
        });

        request.done(function( data ) {
           if(data.success==1){
               window.location.href = "index.php";
           }
            else if(data.success==0){
              $('<div class="row"><div class="large-12 columns"><div data-alert class="alert-box alert ">'+data.message+'</div></div></div>').insertBefore('#signInZone');
           }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });






    });




    /************************************ Login End *************************************/




    /************************************ Sign Up part *************************************/

    $('body').on('click','#click_signUp',function(){
        var getRegEmail = $('#ResEmail').val();
        var getPassword1= $('#ResPassword1').val();
        var getPassword2 = $('#ResPassword2').val();
        var getRegImg =$('#regImg').attr('src');
        if(getRegEmail!='' && getPassword1!='' && getPassword2!=''){


            var request = $.ajax({
            url: 'controller/signUp.controller',
            type: "POST",
            data: {'regEmail':getRegEmail,'regPassword1':getPassword1,'regPassword2':getPassword2,'regImg':getRegImg},
            dataType: 'json'
        });

        request.done(function( data ) {
            if(data.success==1){
                $('<div class="row"><div class="large-12 columns"><div data-alert class="alert-box success">'+data.message+'</div></div></div>').insertBefore('#signUpZone');
                setTimeout(
                    function()
                    {
                        $('#form').foundation('reveal', 'close');
                    }, 5000);
            }
            else if(data.success==0){
                $('<div class="row"><div class="large-12 columns"><div data-alert class="alert-box alert ">'+data.message+'</div></div></div>').insertBefore('#signUpZone');
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

       }
        else{
              $('<div class="row"><div class="large-12 columns"><div data-alert class="alert-box alert ">You have to fill all fields</div></div></div>').insertBefore('#signUpZone');

            }
    });



    $('body').on('click','#regUpload',function(){

        $('body').on("change","input[name='uploadfile']",function(e){
            var file = $("#regUpload")[0].files[0];
            $in=$(this);
            if($in.val()!=''){
                RegAjaxFileUpload();
            }

        });



        });

    function RegAjaxFileUpload(){
        try{
            $.ajaxFileUpload
            (
                {
                    url:'/controller/img.controller.php',
                    secureuri:false,
                    fileElementId:'regUpload',
                    dataType: 'json',
                    success: function (data)
                    {
                        if(data.success==1){

                            $('#regUpload').fadeOut(500,function(){

                                $(this).remove();
                                $('<div class="row"><div class="large-12 columns"><img id="regImg" src='+data.imageAbsolutePathWithResize+'></div></div><br>').insertBefore('#signUpZone');
                            });
                        }


                    }
                }
            )
            return false;

        }catch(err){
            alert(err);
        }


    }



    /************************************ Sign Up End *************************************/


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
                            $('#image_zone').fadeOut(1000,function(){$(this).attr('src',data.imagePathWithResizeUrl).fadeIn(1000);
                                $('.imagepath').empty().text('File bytes: '+data.imgtype+',  FileType: '+ data.imgsize+' , path: ' +data.imagePathWithPrimalUrl);
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
                $('.close-reveal-modal-upload').fadeOut();
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
                    $('#Common_modal').append('<a class="close-reveal-modal close-reveal-modal-upload">&#215;</a><div data-alert="" class="alert-box alert">'+data.error+'</div>');
                });

            }
            else if(data.success==1){

                //get page facepair.php and then append to div of #loadingzone
                if(data.nonface==0){
                $.get("facepair.php", function(getdata){
                    $('#loadingzone').addClass('animated bounceOutLeft').fadeOut(500,function(){

                        $('#pre-faceAnalysis').append(getdata);
                        //execute face information insert operation
                        CurrentFaceInfoToInsert(data.message[0]);

                        GetLocationType(data.message[0].Latitude,data.message[0].Longitude,function(locType){

                            date=getDate(data.message[0].imgDate);

                            var events=GetEvents(locType,date);
                            events=removeDuplicates(events); //some locationType or date returns the same events, need to remove duplicate events name
                            $('<div class="row"><div class="small-7 small-centered columns"><label>Select Event Type<select id="inputSelectType"></select></label><br><a id="'+data.message[0].imgID+'"class="button tiny AddedEvent">Add</a></div></div>').insertAfter('#faceAnalysisResult');
                            $.each(events,function(key,value){
                                $('#inputSelectType').append('<option value='+value+'>'+value+'</option>');

                            });






                        });



                        preQueryMatchedResult(data.message[0]);
                        $('#pre-faceAnalysis').addClass('animated bounceInRight').fadeIn();


                    });

                });
                }
                else if(data.nonface==1){

                    $.get("nonFace.php", function(getdata){
                        $('#loadingzone').addClass('animated bounceOutLeft').fadeOut(500,function(){

                            $('#pre-faceAnalysis').append(getdata);

                            if(data.message.GPSLatitudeRef=='false'){
                                $('#landScopeInfor').text(data.message.createdDate);
                            }

                            else{


                                $('#landScopeInfor').text(data.message.createdDate);
                                    GetLocationType(data.message.GPSLatitudeRef[0],data.message.GPSLatitudeRef[1],function(locType){
                                    date=data.message.createdDate;
                                    var events=GetEvents(locType,date);
                                    events=removeDuplicates(events); //some locationType or date returns the same events, need to remove duplicate events name
                                    $('<div class="row"><div class="small-3 small-centered  columns"><label>Select Event Type<select id="inputSelectType"></select></label><br><a id="'+data.message.id+'" class="button tiny AddedEvent">Add</a></div></div>').insertAfter('#landscape');
                                      $('<h4><small id="locType">Location Type:' +locType+ '</small></h4>').insertAfter('#landscape');



                                        $.each(events,function(key,value){
                                            $('#inputSelectType').append('<option value='+value+'>'+value+'</option>');

                                        });



                                });


                                 returnLoction(data.message.GPSLatitudeRef[1],data.message.GPSLatitudeRef[0],function(location){
                                     $('<h4><small>Location: '+location+'</small></h4>').insertAfter('#landscape');
                                 });





                            }

                            $('#landscape').attr('src',data.message.imageAbsolutePathWithResize);
                            $('#pre-faceAnalysis').addClass('animated bounceInRight').fadeIn();



                        });

                    });
                }


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
     * return the location
     */

    function returnLoction(getCurrentLongitude,getCurrentLatitude,fn){
        if(getCurrentLongitude!=null && getCurrentLatitude!=null){
            //pass coording to check the location
            googleMapLocationApI(getCurrentLongitude,getCurrentLatitude,function(location){
                fn(location);
            });
        }
        else{
            fn('None');
        }

    }


    /**
     * end
     */










    /**
     * google map location api
     */


    function googleMapLocationApI(getCurrentLongitude,getCurrentLatitude,fn){
        $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng='+getCurrentLatitude+','+getCurrentLongitude+'&sensor=true&key=AIzaSyAdDu6W_NBjzSLP4rWagypCtqjrCW5kups',function(data){

             fn(data.results[0].formatted_address);

        });


    }



    /**
     * end
     */



    /**
     * Face base info insert
     */
    function CurrentFaceInfoToInsert(getCurrentValue){
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
        var getCurrentImgID = getCurrentValue.imgID;
        var getCurrentImagePath =getCurrentValue.imgPathWithResizeUrl;
        var getCurrentImgDate =getCurrentValue.imgDate;
        var getCurrentLongitude =getCurrentValue.Longitude;
        var getCurrentLatitude =getCurrentValue.Latitude;
        //update #faceAnalysisResult first, call function
        updateCurrentImage(getCurrentImgID,getCurrentImagePath);
        //update location
        updateFaceAnalysisResult(getCurrentAge,getCurrentAgeRange,getCurrentGender,getCurrentGlass,getCurrentRace,getCurrentSmiling,returnLoction(getCurrentLongitude,getCurrentLatitude,function(address){if(address=='None'){$('#faceAnalysisResult').append('<span class="label success  pairlist">Location:'+address+'</span>  ')}else{$('#faceAnalysisResult').append('<span class="pairlist"><h5><small>Location: '+address+'</small></h5></span>')}}));


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
            $('#faceAnalysisResult').append('<span class="label success" >Age:'+getCurrentAge+' (The range may be around ['+getCurrentAgeRange+'])</span>');
            $('#faceAnalysisResult').append('<span class="label success pairlist">Gender:'+getCurrentGender+'</span>');
            $('#faceAnalysisResult').append('<span class="label  success pairlist">Glass:'+getCurrentGlass+'</span>');
            $('#faceAnalysisResult').append('<span class="label success  pairlist">Race:'+getCurrentRace+'</span');
            $('#faceAnalysisResult').append('<span class="label success  pairlist">Smiling: posibility ('+getCurrentSmiling+')</span>');

        }




    }



    /**
     * end
     */








    /**
     * query and insert matched photo
     */

    function preQueryMatchedResult(result){
        $('#MatchedZone').append('<i style="color:#e74c3c;margin-top:25%" id="matchedPhotoloading"  class="animated bounceln fa fa-refresh fa-spin fa-2x"></i>');

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

                    $('#MatchedZone').append('<div class="row"><div class="large-12 columns" style="margin: 25%"><form><div class="row"><div class="large-5 columns animated fadeInUp"><input type="text" id="namearea" placeholder="Your name, ie. john" /></div><div class="large-2 columns end"><input type="hidden" id="getFaceID" value="'+result.faceID+'"><input type="hidden" id="getFacePlusID" value="'+result.FacePlusID+'"><a class="button tiny addedName">Add</a></div></div></form></div></div>');

                }

            });






        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });



    }


    function inertMatchedResult(result){
        $('#MatchedZone').append('<div class="row"><div class="large-12 columns"><ul id="matchedPhotoThumbs" style="padding:19px" class="small-block-grid-2 medium-block-grid-3 large-block-grid-4" ></ul></div></div>');
        $.each(result,function(key,value){

            $('#matchedPhotoThumbs').append('<li class="animated gridphotolist rollIn" style="position:relative"><div class="matchedImageWrap" ><a class="fancybox" rel="group"  title="Name: '+value.name+', Age: '+value.Age+'{around '+value.Age_range+'}, Gender: '+value.Gender+', Glass: '+value.Glass+', Race: '+value.Race+', Smiling: ('+value.Smiling+'), Silmarilty: '+value.silmarilty.similarity+'" href="'+value.imgPathWithPrimalUrl+'"><img class="matchedImage th" id="'+value.faceID+'" src="'+value.imgPathWithResizeUrl+'"></a></div><h4 class="tickerZone" id="'+value.imgID+'"><small>'+value.name+'</small></h4></li>');
        });

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

    });
    /**
     * end
     */


    /**
     * add a name
     */

    $('body').on('click','.addedName',function(){
        if($('#namearea').val()!=''){

            var name = $('#namearea').val();
            var faceId = $('#getFaceID').val();
            var facePlusId = $('#getFacePlusID').val();


            var request = $.ajax({
                url: 'controller/faceName.controller.php',
                type: "POST",
                data: {'faceID':faceId,'facePlusID':facePlusId,'name':name},
                dataType: 'json'
            });

            request.done(function( data ) {
                if(data.success==1){
                    $('#MatchedZone').fadeOut(500,function(){
                        $(this).empty();
                        $(this).append('<div data-alert="" style="margin:25%;" class="alert-box success">Update Succeeded<a href="#" class="close">×</a></div>');
                        $(this).fadeIn(500);
                        $( ".left-off-canvas-toggle" ).trigger( "click" );
                        $('#click_photoStore').addClass('animated shake');

                    });




                }
                else{
                    alert("error");
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });



        }



        $( ".left-off-canvas-toggle" ).on( "click", function() {});

    });
    /**
     * end
     */


    /**
     * click those matched images and mark them all
     */

    $('body').on('click','.tickerZone',function(){

        var getfaceID = $(this).attr('id');

        if($(this).find('.fa').length>0){
            $(this).find('.fa').addClass('bounceOut').fadeOut(500,function(){$(this).remove();});
            getImageID.remove(getfaceID);

        }
        else{
            getImageID.push(getfaceID);

            $(this).append('<i style="position:absolute;bottom: -22px;left: 47px;color:#e74c3c" class="animated bounceIn fa fa-check-square-o"></i>')

        }

    });


    /**
     * end
     */




    /**
     * photo management
     */
    $('body').on('click','#photoManagement',function(){
        $('#Common_modal').foundation('reveal', 'open', '/controller/imageManagement.controller.php');

    });

    /**
     * end
     */


    /**
     * found on map
     */

    $('body').on('click','#clcik_Found_On_Map',function(){
        clickHiden();
        $('#toFound_On_Map').fadeIn().append('<div class="row"><div class="large-12 columns text-center"><i style="color:#008CBA" class="fa fa-5x fa-cog fa-spin"></i></div></div>');

        var request = $.ajax({
            url: 'controller/queryGeoloactionImage.controller.php',
            type: "POST",
            dataType: 'json'
        });
        request.done(function( data ) {
        console.log(data);
            if(data.success==1){
                $('#toFound_On_Map').fadeIn();
                DisplayMap(data.message);
                google.maps.event.trigger(map, "resize");

            }



        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });






    });

    /**
     * end
     */


    /**
     * google map area
     */
    function DisplayMap(data){
        var photosData=data;


        // set the coordinates of the centre of the map as the location of the first photo
        var centerLat = photosData[0].Latitude;
        var centerLng = photosData[0].Longitude;

        // -----Display the map-----
        var mapOptions = {
            'center': new google.maps.LatLng(centerLat, centerLng),
            'zoom': 12,
            'mapTypeId': google.maps.MapTypeId.ROADMAP
        };


        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        // -----End Display the map-----

        // get the array of photos from the result (JSON object)
        var photos = photosData;

        // Iterate through each photo to display marker on map
        for (var i in photos) {

            //get each photo's info
            var photoId = photos[i].imgID;
            var photoPath_L =  photos[i].imgPathWithPrimalUrl;
            var photoPath_S =  photos[i].imgPathWithIconUrl;
            var photoLat = photos[i].Latitude;
            var photoLon = photos[i].Longitude;
            var photoDate =  photos[i].imgDate;
            var photoAddress = photos[i].Address;
            var photoLatlng = new google.maps.LatLng(photoLat,photoLon);

            //set the icon of marker
            var imgIcon = {
                url: photoPath_S,
                // This marker is 80 pixels wide by 80 pixels tall.
                size: new google.maps.Size(80,60),
            };


            //display markers in the Map
            var  marker = new google.maps.Marker({
                position: photoLatlng,
                map: map,
                title: 'The photo was taken at '+photoAddress+' in ' + photoDate,
                url: photoPath_L,
                icon: imgIcon
            });

            google.maps.event.addListener(marker, 'click', function() {
                $.fancybox({
                    href: this.url,
                    title:this.title
                    // other options

                });

            });

        } //end of for each photo

    } //END function DisplayMap()

    /**
     * end
     */

    function clickHiden(){
        $('#toPhotoStore').fadeOut().empty();
        $('#toEvent').fadeOut().empty();
        $('#toFound_On_Map').fadeOut();
        $('#toGenerate_QR').fadeOut().empty();
        $('#toParied').fadeOut();

    }


    /**
     * click_pair
     */

    $('body').on('click','#click_toParied',function(){
        clickHiden();
        $('#toParied').fadeIn();
    });


    /**
     * end
     */



    /**
     * click_photoStore
     */

    $('body').on('click','#click_photoStore',function(){
        photoStore();

    });

    function photoStore(){
        clickHiden();
        $('#toPhotoStore').empty().fadeIn().append('<div class="row"><div class="large-12 columns text-center"><i style="color:#008CBA" class="fa fa-5x fa-cog fa-spin"></i></div></div>');

        var request = $.ajax({
            url: 'controller/queryAllImage.controller.php',
            type: "POST",
            data: {'queryAll':'request'},
            dataType: 'json'
        });

        request.done(function( data ) {
            if(data.success==1){
                //ready to insert the data
                $.get( "photoStore.php", function( getdata ) {
                    $('#toPhotoStore').fadeOut(500,function(){
                        $(this).empty().append(getdata);
                        $('#filterImageZone').append('<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4 photoDisplay" style="padding: 2px;"></ul>');

                        $.each(data.message,function(key,value){
                                $('.photoDisplay').append('<li class="animated flipInX "><div><a class="fancybox" rel="group" href="'+value.imgPathWithPrimalUrl+'"><img class="th" src="'+value.imgPathWithResizeUrl+'"></a><div class="panel text-center"><div class="row"><div class="large-6 columns"><i class="fa fa-qrcode qrclass fa-lg" id="'+value.imgID+'"></i></div><div class="large-6 columns"><i class="fa fa-pencil-square-o fa-lg"></i></div></div></div></div></li>');

                        });
                        $(this).fadeIn();

                    });

                });
            }
            else{
                // - this is showing the error message
                $('#toPhotoStore').fadeOut(500,function(){
                    $(this).empty().fadeIn().append('<div class="row"><div class="large-12 columns">'+data.message+'</div></div>');
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

   $('body').on('click','#click_toPhotoStore',function(){
       photoStore();
   });



    /**
     * click_filterName
     * update the downdown list
     * and ajax refresh the image content
     */

      $('body').on('click','.navListname>a',function(){
         var getExactName = $(this).text();
          var object = {};
          object['requestType']= 'name';
          object['value'] = getExactName;
          exactlyAjax(object);

      });





    /**
     * end
     */


    /**
     * change nav active
     */

    $('body').on('click','.nav-click',function(){
        $('.nav-click').removeClass('active');
        $(this).addClass('active');


    });


    /**
     * end
     */


    /**
     * exactly ajax function
     */
    function exactlyAjax(data){
        var request = $.ajax({
            url: 'controller/subNav.controller.php',
            type: "POST",
            data: data,
            dataType: 'json'
        });
        request.done(function( data ) {
           if(data.success==1){
               $('#filterImageZone').fadeOut(500,function(){
                   $(this).empty();
                   $(this).append('<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4 photoDisplay" style="padding: 2px;"></ul>');
                   $.each(data.message,function(key,value){
                           $('.photoDisplay').append('<li class="animated flipInX "><div><a class="fancybox" rel="group" href="'+value.imgPathWithPrimalUrl+'"><img class="th" src="'+value.imgPathWithResizeUrl+'"></a><div class="panel text-center"><div class="row"><div class="large-6 columns"><i class="fa fa-qrcode qrclass fa-lg" id="'+value.imgID+'"></i></div><div class="large-6 columns"><i class="fa fa-pencil-square-o fa-lg"></i></div></div></div></div></li>');
                   });
                   $(this).fadeIn();

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
     * click to show all image
     */
    $('body').on('click','#showsALL_noFilter',function(){
        photoStore();

    });

    /**
     * end
     */


    /**
     * click to show face
     */
     $('body').on('click','#click-filterAllface',function(){
         var object= {};
         object['requestType']='allFace';
         object['value'] = 'allFace';
         exactlyAjax(object);



     });

    /**
     * end
     */



    /*
     ** this function takes the Json data of ONE photo, and get the location type of the photo
     ** the location type are passed to fn
     */
    function GetLocationType(getlat,getlng,fn){
        var lat = getlat;
        var lng = getlng;

        var myLatlng = new google.maps.LatLng(lat,lng);

        var mapOptions = {
            'center': myLatlng,
            'zoom': 16,
            'mapTypeId': google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("map2"), mapOptions);

        var request = {
            location: myLatlng,
            radius: '80'
        };

        var service = new google.maps.places.PlacesService(map);
        service.search(request, callback);

        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {

                /*
                 // display location names and location types of search results for testing purpose
                 for(var i in results){
                 console.log("Names: "+results[i].name+"   Type: "+results[i].types);
                 }
                 */

                // get the first three places of the results list
                var places = [results[0],results[1],results[2]];

                var locationType="";

                for(var n=0;n<places.length;n++){

                    var place=places[n];

                    for (var i = 0; i < place.types.length; i++) {
                        locationType += place.types[i];
                        locationType += ",";
                    }
                }

                fn(locationType);
            }

        } //end of call back


    } //end of GetLocationType()


    /*
     *** This function takes a location type and photo date of ONE photo as arguments,
     *** and return the events info of the photo as an array
     *** list of location type of Google Map: https://developers.google.com/places/documentation/supported_types
     */
    function GetEvents(locType,date){

        // an array to store events of the photo, one photo can have many events
        var events = [];


        //-----determine events by location type-----
        if(locType.search("bar")!=-1){

            events.push("party");
        }

        if(locType.search("gym")!=-1){

            events.push("sport");
        }

        if(locType.search("restaurant")!=-1 || locType.search("food")!=-1){

            events.push("food");
            events.push("party");
        }

        if(locType.search("airport")!=-1 || locType.search("aquarium")!=-1 ||locType.search("zoo")!=-1 ){

            events.push("travel");
        }

        if(locType.search("cafe")!=-1 || locType.search("park")!=-1){

            events.push("relax");
        }

        if(locType.search("beauty_salon")!=-1 || locType.search("hair_care")!=-1){

            events.push("beauty");
        }
        if(locType.search("university")!=-1 || locType.search("school")!=-1){

            events.push("learning");
        }


        //-----determine events by photo taken date-----

        if(date=="14-02-2014" || date=="02-08-2014"){

            events.push("love");
        }

        if(date=="01-01-2014" || date=="31-12-2013"){

            events.push("New Year");
        }

        if(date=="28-01-2014"){

            events.push("Australia Day");
        }

        if(date=="18-04-2014" || date=="19-04-2014" || date=="20-04-2014" ||date=="21-04-2014"){

            events.push("Easter");
        }

        if(date=="24-12-2013" || date=="25-12-2013"){

            events.push("Chrismas");
        }

        if(date=="30-01-2014" || date=="31-01-2014"){
            events.push("Chinese New Year");
            events.push("Family");
        }

        return events;

    }

    /*
     ** A function removes the duplicates elements from the array
     */
    function removeDuplicates(arr) {
        return jQuery.unique(arr);
    }


    /**
     * event
     */
    $('body').on('click','.AddedEvent',function(){
        var getEventType =  $('#inputSelectType').val();
        var getImageID = $(this).attr('id');

        var request = $.ajax({
            url: 'controller/event.controller.php',
            type: "POST",
            data: {'event':getEventType,'imgID':getImageID},
            dataType: 'json'
        });
        request.done(function( data ) {
            if(data.success==1){
                $('.AddedEvent').parent().fadeOut();
                $('<div class="row eventUpdateInfot"><div class="small-12 small-centered columns"><div data-alert class="alert-box success">'+data.message+'</div></div></div>').insertAfter($('.AddedEvent').parent());
                setTimeout(
                    function()
                    {
                        if($('body').find('#image-info').length>0){

                            $('#form').foundation('reveal', 'close');
                        }
                        if($('body').find('#faceAnalysisResult').length>0){
                            $('.eventUpdateInfot').fadeOut();
                        }

                        }, 3000);



            }

            else if(data.success==0){
                $('<div class="row"><div class="small-12 small-centered columns">'+data.message+'</div></div>').insertAfter($('.AddedEvent').parent());

            }


        });



        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    });


    /**
     * end
     */


    /**
     * event click to display
     */

    $('body').on('click','#click_Event',function(){

        var object= {};
        object['requestType']='event';
        object['value'] = 'allLandScape';

        exactlyAjax(object);

     });

    /**
     * end
     */


    /**
     * landscape view
     */

    $('body').on('click','#click-filterAllView',function(){

        var object= {};
        object['requestType']='landScape';
        object['value'] = 'allLandScape';

        exactlyAjax(object);



    });
    /**
     * end
     */


    /**
     * gender click
     */
    $('body').on('click','.navListGender>a',function(){
        var object= {};
        object['requestType']='gender';
        object['value'] = $(this).text();
        exactlyAjax(object);


    });

    /**
     * end
     */


    /**
     * event click
     */
    $('body').on('click','.navListEvent>a',function(){
        var object={};
        object['requestType']='event';
        object['value'] = $(this).text();
        exactlyAjax(object);

    });


    /**
     * end
     */


    /**
     * year click
     */
    $('body').on('click','.NavListDate>a',function(){
        var object={};
        object['requestType']='year';
        object['value'] = $(this).text();
        exactlyAjax(object);

    });

    /**
     * end
     */


    /**
     * get date
     */
    function getDate(date) {
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();

        if (month < 10) {
            month = "0" + month;
        }
        return day+'-'+month + '-'+year;
    };

    /**
     * end
     */





    /**
     * click a face image to found the match
     */
        $('body').on('click','.qrclass',function(){
            var getid =$(this).attr('id');
            if($(this).hasClass('fa-qrcode')){

            $(this).fadeOut(500,function(){
                $(this).removeClass('fa-qrcode').addClass('fa-check-square-o').css('color','#e74c3c').fadeIn();
                getImageID.push(getid);

            });

            }
            if($(this).hasClass('fa-check-square-o')){
                $(this).fadeOut(500,function(){
                $(this).removeClass('fa-check-square-o').addClass('fa-qrcode').css('color','#000').fadeIn();
                getImageID.remove(getid);
                });
            }

        });

    /**
     * end
     */


    /**
     * click click_Generate_QR
     */
    $('body').on('click','#click_Generate_QR',function(){
        clickHiden();
        var imgIDArray =removeDuplicates(getImageID);
        if(imgIDArray.length==0){
            $('#toGenerate_QR').fadeIn().append('<div class="row"><div class="large-12 columns text-center"><h2><small>You did not choose any photo</small></h2><div></div>');
        }
        else{
        $('#toGenerate_QR').fadeIn().append('<div class="row"><div class="large-12 columns text-center"><i style="color:#008CBA" class="fa fa-5x fa-cog fa-spin"></i></div></div>');
        $.getJSON('controller/qr.controller.php?imgIDArray='+imgIDArray,function(data){
            $('#toGenerate_QR').fadeOut(500,function(){
                $(this).empty();
                $(this).append('<div class="row"><div class="large-12 columns" ><ul class="inline-list" style="margin-top:19px"><li><h4><small>Currently selected photots</small></h4></li><li><input type="text" placeholder="please input QR name" id="qrName"></li><li><a class="button tiny" id="qrConfirm">Confirm</a></li></ul></div></div>');
                $(this).append('<div class="row"><div class="large-12 columns"><ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4 qrPhoto" style="padding: 2px;"></ul></div>');
                $.each(data.message,function(key,value){

                    $('.qrPhoto').append('<li class="animated flipInX "><div><a class="fancybox" rel="group" href="'+value.imgPathWithPrimalUrl+'"><img class="th" src="'+value.imgPathWithResizeUrl+'"></a></div></li>');

                });
                $(this).fadeIn();

            });


        });
        }

    });

    /**
     * end
     */


    /**
     * QR code confirm
     */
    $('body').on('click','#qrConfirm',function(){
        var imgIDArray =removeDuplicates(getImageID);
        var name =$('#qrName').val();
        if(imgIDArray!='' && name!=''){

            var request = $.ajax({
                url: 'controller/qr.controller.php',
                type: "POST",
                data: {'imgIDArray':imgIDArray,'QrName':name},
                dataType: 'json'
            });
            request.done(function( data ) {
                if(data.success==1){
                    $('#toGenerate_QR').fadeOut(500,function(){
                        $(this).empty().append('<div class="row"><div class="large-12 columns text-center"><img src='+data.message+'><h4><small>'+data.qrName+'</small></h4></h4></div></div>');
                        $(this).fadeIn();


                    });

                }
                else if(data.success=0){
                       alert(data.message);
                }

            });


            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });


        }



    });

    /**
     * end
     */


    /**
     * remove item from array
     */
    Array.prototype.remove = function(x) {
        var i;
        for(i in this){
            if(this[i].toString() == x.toString()){
                this.splice(i,1)
            }
        }
    }

    /**
     * end
     */

});
