function getAllItems(){
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
                
                let response = JSON.parse(dataRequest.responseText);
                
                
                writeNewTableContents(response);
          } else {
            alert('There was a problem with the request.');
          }
        }
      }
      catch( e ) { 
        alert('Caught Exception: ' + e.description);
      }
    };
    
    dataRequest.open('POST','php/miniGetAllItems.php');
    dataRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    dataRequest.send();
    
    
    
}

function writeNewTableContents(response){
    console.log(response);
    let sortedItems = {
        'Common': 'Common: <br>',
        'Uncommon': 'Uncommon: <br>',
        'Legendary': 'Legendary: <br>',
        'Boss': 'Boss: <br>',
        'Lunar': 'Lunar: <br>',
        'Void': 'Void: <br>'
    }
    
    let i=1;
    while(response[i]){
        sortedItems[response[i].rarity]+= '<a href=browser.html?pos='+ i+'>' +response[i].name + '</a><br>';
        i++;
    }
    document.querySelector('#Common').innerHTML = sortedItems.Common;
    document.querySelector('#Uncommon').innerHTML = sortedItems.Uncommon;
    document.querySelector('#Legendary').innerHTML = sortedItems.Legendary;
    document.querySelector('#Boss').innerHTML = sortedItems.Boss;
    document.querySelector('#Lunar').innerHTML = sortedItems.Lunar;
    document.querySelector('#Void').innerHTML = sortedItems.Void;

}
window.addEventListener('load', (event) =>{
    getAllItems()
})
