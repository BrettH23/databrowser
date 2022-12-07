//This function is entirely for quick data entry, it has no bearing on the project.
//With a tampermonkey script I wrote, I grab the data for an item from a wiki to my clipboard, and parse it here to autofill.
//Future me: remember to enable dom.events.testing.asyncClipboard in about:config
function cheekyFill(){
    rawData = document.querySelector('#cheekyText').value;

    xstr='<table>'+rawData+'</table>';
    xstr = xstr.replace(/(\r\n|\n|\r)/gm, "");
    parser = new DOMParser();
    
    var newTable = parser.parseFromString(xstr,"text/html");
    
    
    let mainBody = newTable.querySelector('tbody');
    let cheekyItemName = mainBody.firstChild.firstChild.lastChild.innerHTML;
    
    let namepieces = cheekyItemName.split('</span>');
    cheekyItemName = namepieces[namepieces.length-1];
    

    let cheekyImageUrl = mainBody.firstChild.nextSibling.querySelector('img').getAttribute('src');

    let imagePieces = cheekyImageUrl.split('/')
    let imageUrl2 = imagePieces[0];
    for(let i = 1;i<imagePieces.length-2;i++){
        imageUrl2 = imageUrl2 + '/' + imagePieces[i];
    }
    
    
    //console.log(imageUrl2)

    let unlockCheck = false;
    let cheekyRarity;
    let cheekyCategory;
    trRows = mainBody.querySelectorAll('tr');
    for(let i=0;i< trRows.length;i++){
        if(trRows[i].firstChild.innerHTML=='Rarity'){
            cheekyRarity = trRows[i].firstChild.nextSibling.firstChild.innerHTML;
        }
        else if(trRows[i].firstChild.innerHTML=='Category'){
            cheekyCategory = trRows[i].firstChild.nextSibling.firstChild.innerHTML;
        }
        else if(trRows[i].firstChild.innerHTML=='Unlock'){
            unlockCheck = true;
        }
    }
    //console.log(cheekyRarity);
    //console.log(cheekyCategory);
    //console.log(unlockCheck);
    

    document.querySelector("[name='name']").value = cheekyItemName;
    document.querySelector("[name='rarity']").value = cheekyRarity;
    document.querySelector("[name='category']").value = cheekyCategory;


    let statRow1 = {
        1:mainBody.lastChild.previousSibling.firstChild.innerHTML,
        2:mainBody.lastChild.previousSibling.firstChild.nextSibling.innerHTML,
        3:mainBody.lastChild.previousSibling.lastChild.previousSibling.firstChild.firstChild.innerHTML,
        4:mainBody.lastChild.previousSibling.lastChild.innerHTML,
    };
    let statRow2 = {
        1:mainBody.lastChild.firstChild.innerHTML,
        2:mainBody.lastChild.firstChild.nextSibling.innerHTML,
        3:mainBody.lastChild.lastChild.previousSibling.firstChild.firstChild.innerHTML,
        4:mainBody.lastChild.lastChild.innerHTML,
    };
    
    //console.log(cheekyImageUrl);
    //console.log(statRow2);
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    loadURLToInputField(imageUrl2);


    
    
    //blob converter thanks to https://vulieumang.github.io/vuhocjs/file2input-input2file/
    //You can't specify a url for a file input due to security reasons, but you can grab a file from a url, convert it to a blob and add it that way.
    function loadURLToInputField(url){
        getImgURL(url, (imgBlob)=>{
          // Load img blob to input
          // WIP: UTF8 character error
          let fileName = cheekyItemName + '.png'
          let file = new File([imgBlob], fileName,{type:"image/jpeg", lastModified:new Date().getTime()}, 'utf-8');
          let container = new DataTransfer(); 
          container.items.add(file);
          document.querySelector('#image-input').files = container.files;
          
        })
      }
      // xmlHTTP return blob respond
      function getImgURL(url, callback){
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            callback(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
      }
}