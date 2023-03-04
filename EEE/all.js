let school = window.indexedDB.open("school", 1);
school.onupgradeneeded = function (e) {
  let db = e.target.result;
  let cls = db.createObjectStore(["class"], { autoIncrement: true, keyPath: "id" });
  cls.createIndex("classname", "classname", { unique: true });
  let stu = db.createObjectStore(["student"], { autoIncrement: true, keyPath: "id" });
  stu.createIndex("avator", "avator", { unique: false });
  stu.createIndex("name", "name", { unique: false });
  stu.createIndex("email", "email", { unique: true });
  stu.createIndex("phone", "phone", { unique: true });
  stu.createIndex("address", "address", { unique: false });
  stu.createIndex("classnames", "classnames", { unique: false });
  stu.createIndex("text", "text", { unique: false });
  stu.createIndex("delqus", "delqus", { unique: false });
};