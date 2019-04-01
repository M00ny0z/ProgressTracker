(function() {
  window.addEventListener("load", main);

  function main() {
    console.log("hello");
    console.log(getTimestamp());
  }

  function getTimestamp() {
    let d = new Date();
    let day = d.getDate();
    let year = d.getFullYear();
    let month = d.getMonth() + 1;
    let hour = d.getHours();
    let minute = d.getMinutes();
    let seconds = d.getSeconds();
    if(month < 10) {
      month = "0" + month;
    }
    if(day < 10) {
      day = "0" + day;
    }
    return (year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + seconds);
  }
})();
