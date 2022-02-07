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


window.addEventListener('DOMContentLoaded', function(){

	var input_file = document.querySelector('[name=input_file]');

	input_file.addEventListener('change', function(e){

		if( e.target.files[0].type === 'image/jpeg' || e.target.files[0].type === 'image/png' ) {


			// img要素を作成
			var img_element = document.createElement("img");
			img_element.src = e.target.files[0].name;
			img_element.alt = "アップロードに成功しました";
			img_element.width = 100;
			img_element.onload = function(){
				URL.revokeObjectURL(this.src);
			}

			// ページにimg要素を挿入して画像ファイルを表示
			var div_element = document.getElementById('file_viewer');
			div_element.appendChild(img_element);


		}
	});
});
