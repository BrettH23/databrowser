var position = 1;
//var itemTotal = 0;
//var dataRequest; 
function page(i){
    requestItem(parseInt(i)+parseInt(position));
}
function requestItem(i){
    //position=i;
    //console.log(i);
    dataRequest = new  XMLHttpRequest();
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
                let response = JSON.parse(dataRequest.responseText);
                
                position = response.pos;
                //console.log(position);
                //console.log(response.item);
                writeToPage(response.item);
          } else {
            alert('There was a problem with the request.');
          }
        }
      }
      catch( e ) { // Always deal with what can happen badly, client-server applications --> there is always something that can go wrong on one end of the connection
        alert('Caught Exception: ' + e.description);
      }
    };
    
    dataRequest.open('POST','php/getItem.php');
    dataRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    dataRequest.send('position='+i);
    
    
    
}




function writeToPage(response){
    
    
    
    
    
    
    /*
    position+=page;
    if(position>=itemTotal){
        position = 0;
    }
    if(position<0){
        position = itemTotal-1;
    }
    */
   
    document.querySelector('#image').setAttribute('src', response.image)
    
    document.querySelector('#name-text').innerHTML = response.name;
    document.querySelector('#name-input').querySelector('input').value = response.name;

    document.querySelector('#rarity-text').innerHTML = response.rarity;
    document.querySelector('#rarity-input').querySelector('input').value = response.rarity;

    document.querySelector('#category-text').innerHTML = response.category;
    document.querySelector('#category-input').querySelector('input').value = response.category;

    
    if(response.requires_unlock){
        document.querySelector('#requires-unlock-text').innerHTML = response.name + ' must be earned.';
        document.querySelector('#requires-unlock-input').querySelector('input').checked = true;
    }else{
        document.querySelector('#requires-unlock-text').innerHTML = response.name + ' is unlocked by default.';
        document.querySelector('#requires-unlock-input').querySelector('input').checked = false;
    }
    
    document.querySelector('#stat1-text').innerHTML = 
    'Applies ' + response.stats[0].base + response.stats[0].unit +' ' + response.stats[0].stat + ' with ' + response.stats[0].stack_type +' stacking at a rate of ' +response.stats[0].stack_rate + response.stats[0].unit;
    statFields1 = document.querySelector('#stat1-input').querySelectorAll('input');
    statFields1[0].value = response.stats[0].base;
    statFields1[1].value = response.stats[0].unit;
    statFields1[2].value = response.stats[0].stat;
    statFields1[3].value = response.stats[0].stack_type;
    statFields1[4].value = response.stats[0].stack_rate;
    
    
    if(response.has_two_stats){
        document.querySelector('#has-two-stats').querySelector('input').checked = true;
        document.querySelector('#second-stat').removeAttribute('hidden');   
        
        document.querySelector('#stat2-text').innerHTML = 
        'Applies ' + response.stats[1].base + response.stats[1].unit +' ' + response.stats[1].stat + ' with ' + response.stats[1].stack_type +' stacking at a rate of ' +response.stats[1].stack_rate +response.stats[1].unit;
        statFields2 = document.querySelector('#stat2-input').querySelectorAll('input');
        statFields2[0].value = response.stats[1].base;
        statFields2[1].value = response.stats[1].unit;
        statFields2[2].value = response.stats[1].stat;
        statFields2[3].value = response.stats[1].stack_type;
        statFields2[4].value = response.stats[1].stack_rate;
    }else{
        document.querySelector('#has-two-stats').querySelector('input').checked = false;
        document.querySelector('#second-stat').setAttribute('hidden','true');        
        
        statFields2 = document.querySelector('#stat2-input').querySelectorAll('input');
        statFields2[0].value = '';
        statFields2[1].value = '';
        statFields2[2].value = '';
        statFields2[3].value = '';
        statFields2[4].value = '';
        
    }
    document.querySelector('#position').value=position;
    setColor(response.rarity);
    
}

function setColor(str){
    bg = document.querySelector('body');
    if(str == 'Common')
    {
        bg.style.backgroundColor = '#CCC';
    }
    else if(str == 'Uncommon'){
        bg.style.backgroundColor = '#5A5';
    }
    else if(str == 'Legendary'){
        bg.style.backgroundColor = '#A55';
    }
    else if(str == 'Void'){
        bg.style.backgroundColor = '#A5A';
    }
    else if(str == 'Lunar'){
        bg.style.backgroundColor = '#55A';
    }else{
        bg.style.backgroundColor = '#777';
    }
}


window.onload=function(){
    let params = new URLSearchParams(document.location.search);
    //console.log(Number.isNaN(parseInt(params.get('pos'))));
    let modeInput = document.querySelector('#mode');
    if(params.get('new')!== 'true'){
        if(Number.isNaN(parseInt(params.get('pos')))){
            requestItem(position);
            
        }else{
            requestItem(params.get('pos'));
        }
        modeInput.value='edit';
    }else{
        let z = document.querySelector('#editButton');
        console.log(z)
        z.click();
        z.setAttribute('hidden','true');
        modeInput.value='new';
        document.querySelector('#deleteButton').setAttribute('hidden',true);
        document.querySelector('#cheekyButton').removeAttribute('hidden');
        document.querySelector('#cheekyText').removeAttribute('hidden');
    }

}




