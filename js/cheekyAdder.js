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
    //console.log(cheekyImageUrl);
    let cheekyDataSrc = mainBody.firstChild.nextSibling.querySelector('img').getAttribute('data-src');
    if(cheekyDataSrc !=null){
        cheekyImageUrl = cheekyDataSrc;
    }
    //console.log(cheekyImageUrl);
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
    
    let twoStatCheck = true;
    if(statRow1[1] == 'Stat'){
        twoStatCheck = false;
    }
    
    
    
    document.querySelector("[name='name']").value = cheekyItemName;
    document.querySelector("[name='rarity']").value = cheekyRarity;
    document.querySelector("[name='category']").value = cheekyCategory;
    
    document.querySelector("[name='requires_unlock']").checked = unlockCheck;
    
    
    
    
    document.querySelector("[name='has_two_stats']").checked = twoStatCheck;
    

    if(twoStatCheck){
        document.querySelector("[name='base1']").value = parseFloat(statRow1[2]);
        document.querySelector("[name='unit1']").value = statRow1[2].charAt(statRow1[2].length-1);
        document.querySelector("[name='stat1']").value = statRow1[1];
        document.querySelector("[name='stack_type1']").value = statRow1[3];
        document.querySelector("[name='stack_rate1']").value = parseFloat(statRow1[4]);

        document.querySelector("[name='base2']").value = parseFloat(statRow2[2]);
        document.querySelector("[name='unit2']").value = statRow2[2].charAt(statRow2[2].length-1);
        document.querySelector("[name='stat2']").value = statRow2[1];
        document.querySelector("[name='stack_type2']").value = statRow2[3];
        document.querySelector("[name='stack_rate2']").value = parseFloat(statRow2[4]);

    }
    else{
        document.querySelector("[name='base1']").value = parseFloat(statRow2[2]);
        document.querySelector("[name='unit1']").value = statRow2[2].charAt(statRow2[2].length-1);
        document.querySelector("[name='stat1']").value = statRow2[1];
        document.querySelector("[name='stack_type1']").value = statRow2[3];
        document.querySelector("[name='stack_rate1']").value = parseFloat(statRow2[4]);


    }
    
    
    
    
    
    
    
    
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