<h1>API example</h1>
<form method="post" action="./" id="form">
    <div>
    <label>Item Name</label>
    <input type="text" id="name" name="name" required />
    </div>
    <div>
    <label>Item Description</label>
    <input type="text" id="description" name="description" size="100" required />
    </div>
    <button type="submit" name="submit" value="submit">Send</button>
</form>

<br>

<div id="output">
</div>


<script>
document.getElementById("form").addEventListener("submit", function(e){
    const data = {name: document.getElementById("name").value, description: document.getElementById("description").value};
console.log(data);
    fetch('./API/index.php?cmd=insert', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    })
    .then((response) => response.json())
    .then((data) => {
        console.log('Success:', data);
        alert(JSON.stringify(data));
        window.location.href = "./";
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    e.preventDefault();    //stop form from submitting
});



fetch('./API/index.php?cmd=getAll', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: {},
})
.then((response) => response.json())
.then((data) => {
    console.log('Success:', data);
    Object.keys(data).forEach(key => {
        var obj = data[key];
        if(obj.id != null) {
            document.getElementById("output").innerHTML += "<br>"+ obj.id +" - "+ obj.item_name +": "+ obj.item_description;
        }
    });
})
.catch((error) => {
    console.error('Error:', error);
});
</script>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
