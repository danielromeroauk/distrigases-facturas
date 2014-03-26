jQuery(function($){

  $(document).on('ready', function(){

    var sitio = 'http://localhost/distrigases/';

    $.ajaxSetup({
      headers: {
      'X-CSRF-Token': $('.file-submit:first input[name="_token"]:first').val()
      }
    });

    $('.preview').hover(
      function() {
        $(this).find('a').fadeIn();
      }, function() {
        $(this).find('a').fadeOut();
      }
    );

    $('.file-select').on('click', function(e) {
      e.preventDefault();
      var idinputfile = 'file-'+ $(this).attr('data-articulo');
      $('#'+ idinputfile).click();
    });

    $('input[type=file]').change(function() {
      var file = this.files[0];
      var formdata = false;

      if(window.FormData){
        formdata = new FormData();
      } else {
        alert('Tu navegador no soporta FormData para subida de imágenes.');
        return false;
      }

      if(file.type == 'image/jpeg' || file.type == 'image/png')
      {
        var reader = new FileReader();
        var articulo = $(this).attr('data-articulo');
        var $progreso = $('#div-'+ articulo);

        $progreso.html('').show();
        $progreso.html('<span class="alert alert-info">'+ file.name.toString() +' subiendo...</span>');

        reader.onload = function (e) {
          $('#img-'+ articulo).attr('src', e.target.result);
        };

        reader.readAsDataURL(file);

        if(formdata)
        {
          // var token = document.getElementsByName('_token')[0].value;

          formdata.append('imagen', file);
          // formdata.append('_token', token);

          $.ajax({
            url : sitio+'articulos/cambiar-imagen/'+articulo,
            type : 'POST',
            data : formdata,
            processData : false,
            contentType : false,
            success : function(res){
              $progreso.html('<span class="alert alert-success">'+ res +'</span>').fadeOut(5000);
            },
            error : function(jqXHR){
              $progreso.html('<span class="alert alert-danger">No fue posible cambiar la imagen.</span>');
              $('#img-'+ articulo).attr('src', 'http://placehold.it/640x360');
            }
          });
        } //if formdata

      } else {

        alert('El tipo de archivo '+ file.type +' no está permitido.');

      } // file.type jpeg o png

    });

  }); //on ready

}); //jQuery