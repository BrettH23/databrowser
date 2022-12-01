var editMode = false;

function swapEdit(){
    const textItems = document.querySelectorAll("[id$=text]");
    const inputItems = document.querySelectorAll("[id$=input]");
    x = textItems.length;
    y = inputItems.length;
    console.log(inputItems);
    console.log(textItems);
    let stat2 = document.getElementById('2statChecker');
    if(editMode){
        for(let i = 0;i<x;i++){//using let i in list causes loop to overshoot
            textItems[i].removeAttribute('hidden');
        }
        for(let i = 0;i<y;i++){
            inputItems[i].setAttribute('hidden','true');
        }
        stat2.setAttribute('hidden','true');
        document.querySelector('#deleteButton').setAttribute('hidden','true');
    }else{
        for(let i = 0;i<x;i++){
            textItems[i].setAttribute('hidden','true');
        }
        for(let i = 0;i<y;i++){
            inputItems[i].removeAttribute('hidden');
        }
        stat2.removeAttribute('hidden');
        document.querySelector('#deleteButton').removeAttribute('hidden');
    }
    editMode = !editMode;
}

function deleteItem(){
    dataRequest = new  XMLHttpRequest();
    position = 0;
    position = Number(document.querySelector('#position').value);

    console.log(position);
    if(!dataRequest){
        alert('Error fetching data. Try again or try a different browser.');
        return false;
    }
    
    dataRequest.onreadystatechange = function(){
    try {
        if (dataRequest.readyState === XMLHttpRequest.DONE) {
          if (dataRequest.status === 200) {      
                // We retrieve a piece of text corresponding to some JSON
                // now you have a nice object in the response, you can access its properties and values to populate the different fields of your form
                // the next stages will be about the creation of this JSON from the PHP side, in relation to some data that we extracted from a database
                //alert(httpRequest.responseText); // If you have a bug, use an alert of what is given back from the server (for textual content)
                // if you return something that cannot be converted to an object, then debug the PHP side !
                //let response = JSON.parse(dataRequest.responseText);
                
                
          } else {
            alert('There was a problem with the request.');
          }
        }
      }
      catch( e ) { // Always deal with what can happen badly, client-server applications --> there is always something that can go wrong on one end of the connection
        alert('Caught Exception: ' + e.description);
      }
    };
    
    dataRequest.open('POST','php/deleteItem.php');
    dataRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    dataRequest.send('position='+position);
}

