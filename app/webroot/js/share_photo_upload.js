/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){

        /* example 1 */
        var button = jQuery('#button1'), interval;

        new AjaxUpload(button,{

            //action: 'upload-test.php', // I disabled uploads in this example for security reasons
            action: SiteUrl+'/fronts/upload',
            name: 'userfile',
            responseType:'json',
            onSubmit : function(file, ext){
                // change button text, when user selects file
                button.text('Uploading');

                // If you want to allow uploading only 1 file at time,
                // you can disable upload button
                this.disable();

                // Uploding -> Uploading. -> Uploading...
                interval = window.setInterval(function(){
                    var text = button.text();
                    if (text.length < 13){
                        button.text(text + '.');
                    } else {
                        button.text('Uploading');
                    }
                }, 200);
            },
            onComplete: function(file, response){
                button.text('Add Another Image');
                window.clearInterval(interval);
               
                // enable upload button
                this.enable();
                if(response.image!='' && response.image!=null){
                    var divTag = document.createElement('div');
                    divTag.id = response.image;
                    divTag.align = 'center';

                    divTag.innerHTML = '<img src="'+SiteUrl+'/uploads/temp/'+response.image+'" class="img_border" > <br/>\n\
<a href="javascript:void(0);" onclick="deleteImage(\''+response.image+'\', \'temp\')">delete</a>';
                    // add file to the list
                    jQuery('#imageList').append(divTag);
                }
                else if(response.error!=''){
                    jQuery.alerts.dialogClass = jQuery(this).attr('id'); // set custom style class
                    jAlert(response.error, 'cellsolo Alert', function() {
                        jQuery.alerts.dialogClass = null; // reset to default
                    });

                }
            }
        });
    });

    function deleteImage(image, temp){
       
        jQuery.ajax({
            type:'post',
            url:SiteUrl+'/fronts/deleteImage',
            data:'img='+image+"&val="+temp,
            success:function(response){
                document.getElementById(''+image+'').innerHTML='';
            }
        });
    }


   

