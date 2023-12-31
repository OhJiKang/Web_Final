import {
  getHotMovieAPI,
  getPremierMovie,
  getUpcomingMovie,
  addMovie,
  updateMovie,
} from "../../API/MovieAPI.js";
import { getAllGenre } from "../../API/GenreAPI.js";
import { getAllStudios } from "../../API/StudioAPI.js";
import { getAllLanguages } from "../../API/LanguageAPI.js";
import { getUserByEmail } from "../../API/UserAPI.js";
import { XORDecrypt } from "../../Util/EncryptXOR.js";

let allData = [];
let currentData = [];
let table = $("#table-content").DataTable({
  select: {
    style: "single",
    info: false,
  },
  searching: false,
  language: {
    lengthMenu: "Số kết quả / Trang _MENU_",
    zeroRecords: "Không tìm thấy dữ liệu",
    info: "Hiển thị trang _PAGE_ trên _PAGES_",
    infoEmpty: "Đang tìm kiếm dữ liệu",
    infoFiltered: "(filtered from _MAX_ total records)",
    paginate: {
      first: "Trang đầu",
      last: "Trang cuối",
      next: "Trang sau",
      previous: "Trang trước",
    },
  },
});
$("#table-content_filter").hide();

$(document).ready(() => {
  let authFlag = true;
  if (sessionStorage.getItem('Email')) {
    let email = XORDecrypt(sessionStorage.getItem('Email'));
    getUserByEmail("../../..", email).then(res => {
      if (res.role !== '2') authFlag = false;
    })
  }
  else authFlag = false;

  if (!authFlag) {
    window.location.href = "../../Login_Modal/LoginModal.html";
  }

  $('.logout-container').click(() => {
    sessionStorage.removeItem('Email');
    window.location.href = "../../../";
  })
  table.on("select", function (e, dt, type, indexes) {
    if (type === "row") {
      var data = table.rows(indexes).data();
      fillEditData(data[0][0]);
    }
  });
  $(".item-choosing-block").click(function () {
    $(".item-choosing-block .divider-mini").remove();
    $(this).append("<div class=divider-mini></div>");
  });

  $(".hot-film").click(() => loadHotMovie().then(() => showData()));
  $(".premiere-film").click(() => loadPremierMovie().then(() => showData()));
  $(".upcoming-film").click(() => loadUpcomingMovie().then(() => showData()));
  $(".all-film").click(() => loadAllMovie().then(() => showData()));
  $("#btn-search").click(() => {
    let query = $(".input-place input").val().trim().toUpperCase();
    let languageID = $("#select-language").val();
    let genreID = $("#select-genre").val();
    let studioID = $("#select-studio").val();
    currentData = allData.filter(
      (element) =>
        element.MovieID.search(query) != -1 &&
        (genreID === "" ||
          element.ListGenre.find((x) => x.GenreID === genreID)) &&
        (studioID === "" || element.StudioID === studioID) &&
        (languageID === "" || element.LanguageID === languageID)
    );
    $(".item-choosing-block .divider-mini").remove();
    $(".search-result").parent().append("<div class=divider-mini></div>");
    showData();
  });

  // Add form
  $("#btn-add").click(() => {
    let MovieName = $("#ModalAddUser #name").val().trim();
    let Time = $("#ModalAddUser #time").val().trim();
    let LanguageID = $("#ModalAddUser #language").val().trim();
    let StudioID = $("#ModalAddUser #studio").val();
    let posterFile = $("#ModalAddUser #poster")[0].files[0];
    let imageFiles = $("#ModalAddUser #image")[0].files;

    let Director = $("#ModalAddUser #director").val().trim();
    let listActor = $("#ModalAddUser #actor").val().trim();

    let age = $("#ModalAddUser #age").val();
    let listGenre = $("#ModalAddUser #genre").val();
    let story = $("#ModalAddUser #story").val().trim();
    let Year = $("#ModalAddUser #year").val().trim();
    let Premiere = $("#ModalAddUser #premiere").val();
    let URLTrailer = $("#ModalAddUser #trailer").val();
    if (!posterFile || !imageFiles) return;

    listActor = listActor.split(",").map((e) => e.trim());
    let listImage = [];
    $("#ModalAddUser #poster")[0]
      .files[0].convertToBase64()
      .then((res) => {
        listImage.push({ file: res.result, type: 1 });
      });
    $("#ModalAddUser #image")[0]
      .files.convertAllToBase64(/\.(png|jpeg|jpg|gif)$/i)
      .then(function (res) {
        listImage.push(
          ...res.map((e) => {
            return { file: e.result, type: 2 };
          })
        );
        console.log(listImage);
        addMovie(
          "../../..",
          MovieName,
          Director,
          Year,
          Premiere,
          URLTrailer,
          Time,
          StudioID,
          LanguageID,
          story,
          age,
          listActor,
          listGenre,
          listImage
        ).then((res) => {
          if (res.success == false)
            $("#ModalAddUser .message")
              .text("Thêm thất bại")
              .removeClass("success");
          else
            $("#ModalAddUser .message")
              .text("Thêm thành công")
              .addClass("success");
        });
      });
  });

  // Edit form
  $("#btn-edit").click(() => {
    let MovieID = $("#ModalEditUser #id").val().trim();
    let MovieName = $("#ModalEditUser #name").val().trim();
    let Time = $("#ModalEditUser #time").val().trim();
    let LanguageID = $("#ModalEditUser #language").val().trim();
    let StudioID = $("#ModalEditUser #studio").val();
    let Director = $("#ModalEditUser #director").val().trim();
    let age = $("#ModalEditUser #age").val();
    let story = $("#ModalEditUser #story").val().trim();
    let Year = $("#ModalEditUser #year").val().trim();
    let Premiere = $("#ModalEditUser #premiere").val();
    let URLTrailer = $("#ModalEditUser #trailer").val();

    updateMovie(
      "../../..",
      MovieID,
      MovieName,
      Director,
      Year,
      Premiere,
      URLTrailer,
      Time,
      StudioID,
      LanguageID,
      story,
      age
    ).then((res) => {
      if (res.success == false)
        $("#ModalEditUser .message")
          .text("Sửa thất bại")
          .removeClass("success");
      else {
        $("#ModalEditUser .message").text("Sửa thành công").addClass("success");
      }
    });
  });

  loadAllMovie().then(() => showData()); // page load
  loadAllGenre();
  loadAllStudio();
  loadAllLanguage();
});

function showData() {
  table.clear().draw();
  let data = currentData;
  let numRow = data.length;
  for (let i = 0; i < numRow; i++) {
    let genreList = [];
    data[i].ListGenre.forEach((genre) => {
      genreList.push(genre.GenreName);
    });
    table.row
      .add([
        data[i].MovieID,
        data[i].MovieName,
        data[i].StudioID,
        genreList.join(", "),
        data[i].Premiere,
        data[i].Time,
        data[i].LanguageID,
        data[i].Director,
        data[i].rating,
        data[i].story,
      ])
      .draw();
  }
}

async function loadPremierMovie() {
  currentData = [];
  let page = 1;
  let data;
  do {
    data = await getPremierMovie("../../..", page);
    currentData.push(...data);
    page++;
  } while (data.length != 0);
}

async function loadHotMovie() {
  currentData = [];

  let data = await getHotMovieAPI("../../..");
  currentData.push(...data);
}

async function loadUpcomingMovie() {
  currentData = [];

  let page = 1;
  let data;
  do {
    data = await getUpcomingMovie("../../..", page);
    currentData.push(...data);
    page++;
  } while (data.length != 0);
}

async function loadAllMovie() {
  currentData = [];

  let page = 1;
  let data;
  do {
    data = await getUpcomingMovie("../../..", page);
    currentData.push(...data);
    page++;
  } while (data.length != 0);
  page = 1;
  do {
    data = await getPremierMovie("../../..", page);
    currentData.push(...data);
    page++;
  } while (data.length != 0);
  allData = [...currentData];
}

async function loadAllGenre() {
  let page = 1;
  let genreData = [];
  let data;
  let options = [];
  do {
    data = await getAllGenre("../../..", page);
    genreData.push(...data.genres);
    page++;
  } while (data.genres.length != 0);
  genreData.forEach((element) => {
    $("#select-genre").append(
      `<option value=${element.GenreID}>${element.GenreName}</option>`
    );
    options.push({ id: element.GenreID, name: element.GenreName });
  });
  $(".modal #genre").selectize({
    valueField: "id",
    labelField: "name",
    options: options,
  });
  console.log(genreData);
}

async function loadAllStudio() {
  let data = await getAllStudios("../../..");
  data.studios.forEach((element) => {
    $("#select-studio").append(
      `<option value=${element.StudioID}>${element.StudioName}</option>`
    );
    $(".modal #studio").append(
      `<option value=${element.StudioID}>${element.StudioName}</option>`
    );
  });
}

async function loadAllLanguage() {
  let data = await getAllLanguages("../../..");
  data.Language.forEach((element) => {
    $("#select-language").append(
      `<option value=${element.LanguageID}>${element.LanguageName}</option>`
    );
    $(".modal #language").append(
      `<option value=${element.LanguageID}>${element.LanguageName}</option>`
    );
  });
}

function fillEditData(id) {
  let editModal = $("#ModalEditUser");
  let data = currentData.find((e) => e.MovieID === id);
  editModal.find("#id").val(data.MovieID);
  editModal.find("#name").val(data.MovieName);
  editModal.find("#time").val(data.Time);
  editModal.find("#language").val(data.LanguageID).change();
  editModal.find("#studio").val(data.StudioID).change();
  editModal.find("#director").val(data.Director);
  editModal.find("#age").val(data.age);
  editModal.find("#trailer").val(data.URLTrailer);
  editModal.find("#year").val(data.Year);
  editModal.find("#premiere").val(data.Premiere);
  editModal.find("#story").val(data.story);
  editModal.modal("show");
}

File.prototype.convertToBase64 = function () {
  return new Promise(
    function (resolve, reject) {
      var reader = new FileReader();
      reader.onloadend = function (e) {
        resolve({
          fileName: this.name,
          result: e.target.result,
          error: e.target.error,
        });
      };
      reader.readAsDataURL(this);
    }.bind(this)
  );
};

FileList.prototype.convertAllToBase64 = function (regexp) {
  // empty regexp if not set
  regexp = regexp || /.*/;
  //making array from FileList
  var filesArray = Array.prototype.slice.call(this);
  var base64PromisesArray = filesArray
    .filter(function (file) {
      return regexp.test(file.name);
    })
    .map(function (file) {
      return file.convertToBase64();
    });
  return Promise.all(base64PromisesArray);
};
