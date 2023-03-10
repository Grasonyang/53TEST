let shop=window.indexedDB.open('shop',1);

shop.onupgradeneeded=function(e){
    let db=e.target.result;
    let type=db.createObjectStore(["type"],{autoIncrement:true,keyPath:"id"});
    type.createIndex("itext","itext",{unique:true});
    type.createIndex("ihtml","ihtml",{unique:false});
    type.createIndex("AORN","AORN",{unique:false});
    let shopdata=db.createObjectStore(["shopdata"],{autoIncrement:true,keyPath:"id"});
    shopdata.createIndex("type","type",{unique:false});
    shopdata.createIndex("img","img",{unique:false});
    shopdata.createIndex("link","link",{unique:false});
    shopdata.createIndex("name","name",{unique:false});
    shopdata.createIndex("intro","intro",{unique:false});
    shopdata.createIndex("fee","fee",{unique:false});
    shopdata.createIndex("time","time",{unique:false});
};