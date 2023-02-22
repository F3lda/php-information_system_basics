<?php
    if(isset($_GET["UPLOAD"])){

        $dir = 'files';

        $files = array();
        foreach ($_FILES as $upload => $fileUploads) {
            $fileKeys = array_keys($fileUploads);
            
            if (isset($fileUploads["name"])) {
                
                for ($i = 0; $i < count($fileUploads["name"]); $i++) {
                    
                    foreach ($fileKeys as $key) {
                        $files[$upload."-".($i+1)][$key] = $fileUploads[$key][$i];
                    }
                }
            }
        }
        
        foreach ($files as $file) {
            echo "<p>";
            if (isset($file['error']) || !is_array($file['error'])) {
                if ($file['error'] == UPLOAD_ERR_OK) {
                    if (isset($dir) && is_dir($dir)) {
                        $newFile = "./".$dir."/".$file['name'];
                        if (!file_exists($newFile)){
                            if (move_uploaded_file($file['tmp_name'], $newFile)) {
                                chmod($newFile, 0777);
                                // UPLOAD OK!
                                echo "Your file: {$file['name']} has been successfully received.";
                            } else {
                                echo "Failed to move uploaded file.";
                            }
                        } else {
                            echo "File [". $file['name'] ."] already exists.";
                        }
                    } else {
                        echo "Target directory not found.";
                    }
                } else if ($file['error'] == UPLOAD_ERR_NO_FILE) {
                    //echo "No file sent.";
                } else if ($file['error'] == UPLOAD_ERR_INI_SIZE || $file['error'] == UPLOAD_ERR_FORM_SIZE) {
                    echo "Exceeded filesize limit.";
                } else {
                    echo "Unknown error.";
                }
            } else {
                echo "Invalid parameters.";
            }
            echo "</p>";
        }


        if(count($files) == 0) {
            echo '<span>Nothing has been uploaded!</span><br><br>';
        }


        echo '<button onclick="window.location.href = \'./\';">Back to Upload form</button><br>';

    } else {
?>



    <script type="text/javascript">
        function upload_changed(){
            var i;
            var count = 0;
            var used = 0;
            var last = 0;
            for(i = 0; i < document.upload.elements.length; i++){
                if(document.upload.elements[i].type == 'file'){
                    count++;
                    if(document.upload.elements[i].value.length > 0){
                        used++;
                    }
                    last = i;
                }
            }
            if(used >= count){
                var lastfile = document.upload.elements[last];
                if(lastfile){
                    count++;
                    var inputfile = document.createElement('input');
                    inputfile.type = 'file';
                    inputfile.size = 40;
                    inputfile.name = 'upload_'+count+"[]";
                    inputfile.onchange = upload_changed;
                    inputfile.multiple = ' ';
                    lastfile.parentNode.insertBefore(inputfile, lastfile.nextSibling);
                    var br = document.createElement('br');
                    lastfile.parentNode.insertBefore(br, lastfile.nextSibling);
                    lastfile.parentNode.insertBefore(br, lastfile.nextSibling);
                }
            }
        }
	</script>
	<form name="upload" action="./?UPLOAD" method="POST" enctype="multipart/form-data">
		Files: <br>
		<input type="file" name="upload_1[]" size="40" onchange="upload_changed()" multiple>
        <br>
        <br>
        <input type="submit" name="submit" value="Upload files">
	</form>



<?php 
        echo "<br><br><br>Uploaded files:<br>";
        foreach (array_diff(scandir('./files/'), array('.', '..', 'index.php')) as $item)
        {
            echo '<li><a href="./files/'.$item.'" target="_blank">'.$item.'</a></li>';
        }

    }
?>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
