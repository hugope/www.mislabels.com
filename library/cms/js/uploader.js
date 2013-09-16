//Upload files
$(document).ready(function(){
		$('input.fileuploader').fileupload({
	        progressall: function (e, data) {
	            var progress = parseInt(data.loaded / data.total * 100, 10);
	            $('#progress .bar').css(
	                'width',
	                progress + '%'
	            );
	        },
	        done: function (e, data){
	        	$('#progress .bar').css('width', '0');
				if(data.jqXHR.statusText == 'OK'){
	        	var str = data.jqXHR.responseText; //Obtener la respuesta en un string con el JSON
				str = JSON.stringify(eval('('+str+')')); //Convertir el string en un archivo JSON para javascript
				var objectResponse = $.parseJSON(str); //Convertir el JSON en un Objeto
				//Si no se retorna un error
				if(objectResponse.ERROR === undefined){
					
					//Crear los campos con las imagenes
		        	var filedata 		= data.files[0]; //Obtener informaci�n del archivo subido
					$('#imageInputs').append('<input type="hidden" name="galleryImgs[]" class="galleryImg" value="'+ filedata.name +'" />');
		        	
		        	//Obtener el total de im�genes
		        	var images			= 0;
	        		var totalImgs 		= $('input.galleryImg').size(); //N�mero total de im�genes, respecto a los campos
	        		var galleryGroups	= Math.ceil(Number(totalImgs / 3)); //N�mero de grupos por cada tres im�genes
	        		var imgsArray		= []; //Crear un array para todas las im�genes
	        		$.each($('input.galleryImg'), function(){
	        			$(this).attr('id', 'closeImg'+(images++)); //Agregar un id a al campo de la imagen para eliminarla al seleccionar eliminar en el listado
	        			imgsArray.push($(this).val()); //Agregar cada imagen al array
	        		});
	        		var galleryArray	= []; //Crear un array para cada grupo de im�genes
	        		for(var i = 0; i < galleryGroups; i++){
	        			galleryArray[i]	= []; //Crear un array en cada grupo de im�genes
	        		}
	        		for(var i = 0; i < imgsArray.length; i++){
	        			var groupNumber = Math.floor(Number((i)/3)); //Obtener el array del grupo al que pertenece la imagen
	        			galleryArray[groupNumber].push([imgsArray[i], i]); // Agregar al grupo, la imagen correspondiente
	        		}
	        		var thumbsContainer = $('#thumbs_container'); //Establecer el contenedor de los thumbnails
	        		thumbsContainer.html(''); //Vaciar las im�genes en el contenedor
	        		for(var i = 0; i < galleryArray.length; i++){
	        			thumbsContainer.prepend('<ul class="thumbnails" id="thumbsGroup'+i+'"></ul>'); //Agregar los grupos de im�genes como listas
	        			for(var e = 0; e < 3; e++){
	        				if(galleryArray[i][e] != undefined){ //Agregar en cada listado tres im�genes
	        					$('ul#thumbsGroup'+i).prepend('<li class="span4" style="position:relative;"><a href="#modalImgRemove" role="button" data-toggle="modal" class="close removegalleryimg" id="closeImg'+galleryArray[i][e][1]+'" style="position:absolute; right:10px;top:3px;" href="#">&times;</a><div class="thumbnail"><img src="'+base_url+'/user_files/uploads/'+ galleryArray[i][e][0] +'" alt=""></div></li>').fadeIn(500); 
	        				}
	        			}
	        		}
				}else{
					$('span#upload_error').html(objectResponse.ERROR).fadeIn(500).delay(1500).fadeOut(500);
				}
				}else{
					$('span#upload_error').fadeIn(500).delay(1500).fadeOut(500);
				}
	        	console.log(data);
	        	
	        	//Establecer la imagen a remover
				set_image_to_delete();
	        }
		});
		
		set_image_to_delete();
});
function set_image_to_delete(){
  	//Establecer la imagen a remover
	$('a.removegalleryimg').click(function(){
		var imagetodelete = $(this).attr('id');
		$('a#deleteconfirm').attr('imagetodelete', imagetodelete);
	});
	//Al confirmar , eliminar la imagen
	$('a#deleteconfirm').click(function(){
		var deleteImg 	= $(this).attr('imagetodelete');
		$('a#'+deleteImg).parent('li').fadeOut('slow');
		$('input#'+deleteImg).remove();
	});
}
