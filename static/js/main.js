$("#form_create_project").submit(function (event) {

        var data = $("#form_create_project").serialize();
        console.log(data);
        event.preventDefault();


        $.ajax({
            url: 'http://localhost:1123/php-ci-test/project/create',
            type: 'post',
            data: data,
            cache: false,
            success: function () {
                newDiv = '<p>Created by ajax</p>';
                $("#form_create_project").append(newDiv);
            },
            error: function (xhr, desc, err) {
                console.log(xhr + "\n" + err);
            }
        }); // end ajax call
    }
);

