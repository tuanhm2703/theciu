<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
    </head>
    <body>
        <link
            href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/file.min.css"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/image.min.css"
            rel="stylesheet"
            type="text/css"
        />

        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"
        ></script>
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/plugins/file.min.js"
        ></script>
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/plugins/image.min.js"
        ></script>

        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/gh/edsdk/froala-file-manager@latest/js/froala-file-manager.js"
        ></script>
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/gh/edsdk/froala-image-editor@latest/js/froala-image-editor.js"
        ></script>

        <h1 class="h5 mb-3">Flmngr: Froala file manager</h1>

        <textarea id="editor"></textarea>
    </body>
    <script>
        new FroalaEditor("#editor", {
            Flmngr: {
                apiKey: "9Us7prCb", // default free key
                urlFileManager: "http://theciu.local/test", // demo server
                urlFiles: "http://theciu.local/img", // demo file storage
            },
        });
    </script>
</html>
