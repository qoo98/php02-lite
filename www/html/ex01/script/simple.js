$(document).ready(function(){
    $("#src_img").change(function(){
            var formData = new FormData();
            formData.append("image", $("#src_img")[0].files[0]);
            formData.append("other", "123");
            $.ajax({url: 'list.php',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType : 'json',
                        data: formData
                        });
        });
});

