$(document).ready(function() {
    var dropZone = $('#dropZone'),
        maxFileSize = 10485760; // максимальный размер файла - 10 мб.

    if (typeof(window.FileReader) == 'undefined') {
        dropZone.text('Не поддерживается браузером!');
        dropZone.addClass('error');
    }

    dropZone[0].ondragover = function() {
        dropZone.addClass('hover');
        return false;
    };
        
    dropZone[0].ondragleave = function() {
        dropZone.removeClass('hover');
        return false;
    };

    dropZone[0].ondrop = function(event) {
        event.preventDefault();
        dropZone.removeClass('hover');
        dropZone.addClass('drop');

        var file = event.dataTransfer.files[0];
        
        if (file.size > maxFileSize) {
            dropZone.text('Файл слишком большой! Размер файла не должен превышать 10 МБ.');
            dropZone.addClass('error');
            $('#add_image').removeClass('drop');            
            $('#add_image').prop('disabled', true);
            return false;
        } else {
            $('#add_image').prop('disabled', false);
            $('#add_image').attr('data-method', 'store');
            $('#add_image').addClass('drop');
        }

        console.log(file);

        var xhr = new XMLHttpRequest();
        var formData = new FormData(document.forms.uploadImagesForm);

        var method = $('#add_image').attr('data-method');
        if (method == 'store') {
            var filename = $('#filename').val();
            var alt = $('#alt').val();
            // var formData = new FormData();

            formData.append('name', filename);
            formData.append('alt', alt);
            formData.append('path', 'product');
            formData.append('method', method);
            formData.append('image', file);

            console.log(FormData);
        } else if (method == 'update') {
            var filename = $('#filename').val();
            var alt = $('#alt').val();
            var image_id = $('#add_image').attr('data-id');
            // var formData = new FormData();

            formData.append('method', method);
            formData.append('name', filename);
            formData.append('alt', alt);
            formData.append('id', image_id);
            formData.append('path', 'product');
        }
            
        xhr.upload.addEventListener('progress', uploadProgress, false);
        xhr.onreadystatechange = stateChange;
        xhr.open('POST', '/admin/uploadimg');
        xhr.setRequestHeader('X-FILE-NAME', file.name);
        // xhr.send(file);
        xhr.send(formData);

        function uploadProgress(event) {
            var percent = parseInt(event.loaded / event.total * 100);
            dropZone.text('Загрузка: ' + percent + '%');
        }

        function stateChange(event) {
            if (event.target.readyState == 4) {
                if (event.target.status == 200) {
                    dropZone.text('Загрузка успешно завершена!');
                } else {
                    dropZone.text('Произошла ошибка!');
                    dropZone.addClass('error');
                }
            }
        }
    };

    
});