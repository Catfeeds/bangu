<!--Page Related Scripts-->
<script src="assets/js/bootbox/bootbox.js"></script>
<script>
        $("#bootbox-regular").on('click', function () {
            bootbox.prompt("What is your name?", function (result) {
                if (result === null) {
                    //Example.show("Prompt dismissed");
                } else {
                    //Example.show("Hi <b>"+result+"</b>");
                }
            });
        });

        $("#bootbox-confirm").on('click', function () {
            bootbox.confirm("Are you sure?", function (result) {
                if (result) {
                    //
                }
            });
        });

        $("#bootbox-options").on('click', function () {
            bootbox.dialog({
                message: $("#myModal").html(),
                title: "New E-Mail",
                className: "modal-darkorange",
                buttons: {
                    success: {
                        label: "Send",
                        className: "btn-blue",
                        callback: function () { }
                    },
                    "Save as Draft": {
                        className: "btn-danger",
                        callback: function () { }
                    }
                }
            });
        });

        $("#bootbox-success").on('click', function () {
            bootbox.dialog({
                message: $("#modal-success").html(),
                title: "Success",
                className: "",
            });
        });
    </script>