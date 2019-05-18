(function() {
  window.addEventListener("load", main);

  const BASE_URL = "localhost/progresstracker"
  const INFO_URL = BASE_URL + "/info.php?";

  function main() {
    getClasses();
    let noticeLink = document.getElementById("notice");
    let hwLink = document.getElementById("homework");
    let otherLink = document.getElementById("other");
    noticeLink.addEventListener("click", switchCurrentView);
    hwLink.addEventListener("click", switchCurrentView);
    otherLink.addEventListener("click", switchCurrentView);
    noticeLink.addEventListener("click", switchActiveListItem);
    hwLink.addEventListener("click", switchActiveListItem);
    otherLink.addEventListener("click", switchActiveListItem);

    let turnins = document.getElementById('myChart').getContext('2d');
    let chart = new Chart(turnins, {
        type: 'pie',

        // The data for our dataset
        data: {
            labels: ['Early', 'On-time', 'Late'],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: ['rgb(51, 0, 111)', 'rgb(145, 123, 76)', 'rgb(128, 128, 128)'],
                borderColor: '#ffffff',
                data: [1, 10, 2]
            }]
        },

        // Configuration options go here
        options: {}
    });

    let ctx = document.getElementById('my-time').getContext('2d');
    let timeChart = new Chart(ctx, {
        type: 'pie',

        // The data for our dataset
        data: {
            labels: ['Sleep', 'Work', 'Study', 'Social', 'Relax', 'UNKNOWN'],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: ['rgb(40, 61, 59)', 'rgb(25, 114, 120)', 'rgb(237, 221, 212)',
                'rgb(196, 69, 54)', 'rgb(119, 46, 37)', 'rgb(1, 1, 1)'],
                borderColor: '#ffffff',
                data: [6, 5, 5, 1, 1, 6]
            }]
        },

        // Configuration options go here
        options: {}
    });

    let removeButtons = document.querySelectorAll(".toremove");
    for(let i = 0; i < removeButtons.length; i++) {
      removeButtons[i].addEventListener("click", addToRemove);
    }
  }



  function switchCurrentView() {
    let newSectionId = this.id + "-alerts";
    let parentView = document.getElementById("parent-view");
    let allSections = parentView.querySelectorAll("div");
    let visibleSection = getVisibleView(allSections, "visible");
    visibleSection.classList.add("d-none");
    visibleSection.classList.remove("visible");
    let activeSection = document.getElementById(newSectionId);
    activeSection.classList.add("visible")
    activeSection.classList.remove("d-none");
  }

  function getClasses() {
    let url =  "localhost/progresstracker/info.php?mode=getClasses";
    fetch("info.php?mode=getClasses")
      .then(checkStatus)
      .then(JSON.parse)
      .then(addClasses)
      .catch(console.log);
  }

  function addClasses(classData) {
    let addClassBtn = document.getElementById("add-class-btn");
    let classHeader = document.getElementById("class-name");
    if(classHeader.innerHTML === "Class X") {
      console.log("first class:");
      // GETS THE ASSIGNMENTS FOR THE FIRST TIME
      getAssignments(classData.classes[0]);
    }
    classHeader.innerHTML = classData.classes[0];
    let classesList = document.getElementById("class-list");
    for(let i = 0; i < classData.classes.length; i++) {
      let newClass = document.createElement("a");
      newClass.classList.add("dropdown-item");
      newClass.href="#my-classes";
      newClass.innerHTML = classData.classes[i];
      newClass.addEventListener("click", changeClass);
      classesList.insertBefore(newClass, classesList.lastElementChild);
    }
  }

  function createSwitch(id) {
    id = "customSwitch" + id;
    let switchTD = document.createElement("td");
    let switchDiv = document.createElement("div");
    let inputTag = document.createElement("input");
    let label = document.createElement("label");
    switchDiv.classList.add("custom-control");
    switchDiv.classList.add("custom-switch");
    inputTag.type="checkbox";
    inputTag.classList.add("custom-control-input");
    inputTag.id=id;
    label.classList.add("custom-control-label");
    label.setAttribute("for", id);
    switchDiv.appendChild(inputTag);
    switchDiv.appendChild(label);
    switchTD.appendChild(switchDiv);
    return switchTD;
  }

  function createCalendar(id, duedate) {
    id = "datetimepicker" + id;
    let calendarTD = document.createElement("td");
    let calendarDiv = document.createElement("div");
    let formDiv = document.createElement("div");
    let inputTag = document.createElement("input");
    let inputDiv = document.createElement("div");
    let iconDiv = document.createElement("div");
    let calendarIcon = document.createElement("i");
    calendarDiv.classList.add("form-group");
    formDiv.classList.add("input-group");
    formDiv.classList.add("date");
    formDiv.id = id;
    formDiv.setAttribute("data-target-input", "nearest");
    inputTag.type = "text";
    inputTag.classList.add("form-control");
    inputTag.classList.add("datetimepicker-input");
    inputTag.setAttribute("data-target", "#" + id);
    inputTag.value = duedate;
    inputDiv.classList.add("input-group-append");
    inputDiv.setAttribute("data-target", "#" + id);
    inputDiv.setAttribute("data-toggle", "datetimepicker");
    iconDiv.classList.add("input-group-text");
    calendarIcon.classList.add("fa");
    calendarIcon.classList.add("fa-calendar");
    iconDiv.appendChild(calendarIcon);
    inputDiv.appendChild(iconDiv);
    formDiv.appendChild(inputDiv);
    formDiv.appendChild(inputTag);
    calendarDiv.appendChild(formDiv);
    calendarTD.appendChild(calendarDiv);
    $(function () {
        $('#' + id).datetimepicker();
    });
    return calendarTD;
  }

  function getAssignments(className) {
    console.log("info.php?mode=getAssigns&class=" + className);
    fetch("info.php?mode=getAssigns&class=" + className)
      .then(checkStatus)
      .then(JSON.parse)
      .then(addAssignments)
      .catch(console.log)
  }

  function addAssignments(assignData) {
    let assignParent = document.getElementById("assign-parent");
    assignParent.innerHTML = "";
    for(let i = 0; i < assignData.assignments.length; i++) {
      let newRow = document.createElement("tr");
      let rowHeader = document.createElement("th");
      // ADD ASSIGNMENT NAME
      rowHeader.innerHTML = assignData.assignments[i].name;
      let newSwitch = createSwitch(i);
      let newCalendar = createCalendar(i, assignData.assignments[i].duedate);
      let newTurnIn = document.createElement("td");
      console.log(assignData.assignments[i].turnin);
      // ADD ASSIGNMENT TURN IN TIME
      if(assignData.assignments[i].turnin === null) {
        newTurnIn.innerHTML = "N/A";
      } else {
        newTurnIn.innerHTML = assignData.assignments[i].turnin;
      }
      let newGrade = document.createElement("td");
      // ADD ASSIGNMENT GRADE
      newGrade.innerHTML = assignData.assignments[i].grade;
      let removeButton = document.createElement("td");
      let removeIcon = document.createElement("i");
      removeIcon.classList.add("fas");
      removeIcon.classList.add("fa-times");
      removeIcon.classList.add("text-danger");
      removeIcon.classList.add("toremove");
      removeIcon.addEventListener("click", addToRemove);
      removeButton.appendChild(removeIcon);
      newRow.appendChild(rowHeader);
      newRow.appendChild(newCalendar);
      newRow.appendChild(newSwitch);
      newRow.appendChild(newTurnIn);
      newRow.appendChild(newGrade);
      newRow.appendChild(removeButton);
      assignParent.appendChild(newRow);
    }
  }

  function changeClass() {
    let className = this.innerHTML;
    let classHeader = document.getElementById("class-name");
    classHeader.innerHTML = className;
    getAssignments(className);
  }

  function addSubjectSeries(modalParent, series) {
    let seriesMap = new Map();
    seriesMap.set("MATH", ["MATH120", "MATH124", "MATH125", "MATH126"]);
    seriesMap.set("CSE", ["CSE142", "CSE143"]);
    seriesMap.set("PHYS", ["PHYS121", "PHYS122", "PHYS123"]);
    seriesMap.set("PHYS", ["PHYS121", "PHYS122", "PHYS123"]);
    seriesMap.set("CHEM", ["CHEM142", "CHEM152", "CHEM162"]);
    seriesMap.set("BIOL", ["BIOL180", "BIOL200", "BIOL220"]);
    let selectedSeries = seriesMap.get(series);
    for(let i = 0; i < selectedSeries.length; i++) {
      let newButton = document.createElement("button");
      button.classList.add("btn");
      button.classList.add("btn-husky");
      button.classList.add("btn-lg");
      button.classList.add("mb-1");
      button.innerHTML = selectedSeries[i];
    }
  }

  function switchActiveListItem() {
    let parentList = document.getElementById("quick-links");
    let currentActive = parentList.querySelector(".active");
    currentActive.classList.remove("active");
    this.classList.add("active");
  }

  function getVisibleView(allSections, lookingClass) {
    for(let i = 0; i < allSections.length; i++) {
      if(allSections[i].classList.contains(lookingClass)) {
        return allSections[i];
      }
    }
  }

  function addToRemove() {
    this.parentElement.parentElement.classList.toggle("bg-remove");
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

  function $(id) {
    return document.getElementById(id);
  }

  function addCustomAssignment() {
  }

    /**
    * Checks and reports on the status of the fetch call
    * @param {String} response - The response from the fetch that was made previously
    * @return {Promise/String} - The success code OR The error promise that resulted from the fetch
  */
  function checkStatus(response) {
    if (response.status >= 200 && response.status < 300 || response.status === 0) {
      return response.text();
    } else {
      return Promise.reject(new Error(response.status + ": " + response.statusText));
    }
  }

})();
