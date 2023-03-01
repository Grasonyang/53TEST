let school=window.indexedDB.open('school',1);
let db;
school.onupgradeneeded=function(event){
    db=event.target.result;
    let cls=db.createObjectStore("class",{autoIncrement:true, keyPath: "id" });
    cls.createIndex("classname","classname",{unique:true});
    let std=db.createObjectStore("student",{autoIncrement:true, keyPath: "id" });
    std.createIndex("avatar", "avatar", { unique: false });
    std.createIndex("last_name", "last_name", { unique: true });
    std.createIndex("first_name", "first_name", { unique: true });
    std.createIndex("email", "email", { unique: true }); // ','
    std.createIndex("phone", "phone", { unique: true });
    std.createIndex("address", "address", { unique: false });
    std.createIndex("classname", "classname", { unique: false });
    std.createIndex("note", "note", { unique: false });
};