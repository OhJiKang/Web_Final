const getShowTimeByID = async (url, id=1) => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getShowTimeById&id=${id}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
const getAllShowTime = async (url, page=1) => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getAllShowTime&page=${page}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
const getAllShowTimesByDate = async (url, date = "2022-10-10") => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getShowTimeByDate&date=${date}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
const getShowTimeByDateAndGenre = async (
  url,
  date = "2022-10-10",
  Genre = ""
) => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getShowTimeByDateAndGenre&date=${date}&genre=${Genre}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
const getShowTimeByMovieandTheater = async (
  url,
  movieid = 1,
  Theaterid = 1,
  date = "2022-10-10"
) => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getShowTimeByMovieandTheater&movieid=${movieid}&Theaterid=${Theaterid}&date=${date}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
const getAllShowtimeByMovieID = async (
  url,
  movieid = 1,
  date = "2022-10-10"
) => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getAllShowtimeByMovieID&movieid=${movieid}&date=${date}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
const updateShowTime = async (
  url = "../..",
  Price,
  StartTime,
  MovieID,
  EndTime,
  RoomID,
  FormatID,
  ShowtimeID
) => {
  const urls = `${url}/Controller/Showtime/ajax.php`;
  const data = await fetch(urls, {
    method: "PUT",
    body: JSON.stringify({
      Price: Price,
      StartTime: StartTime,
      MovieID: MovieID,
      EndTime: EndTime,
      RoomID: RoomID,
      FormatID: FormatID,
      ShowtimeID: ShowtimeID,
    }),
  });
  const datatorender = await data.json();
  return datatorender;
};

const removeShowTime = async (url = "../..", movieid) => {
  const urls = `${url}/Controller/Showtime/ajax?movieid=${movieid}.php`;
  const data = await fetch(urls, {
    method: "DELETE",
  });
  const datatorender = await data.json();
  return datatorender;
};

const addShowTime = async (
  url = "../..",
  Price,
  StartTime,
  MovieID,
  EndTime,
  RoomID,
  FormatID
) => {
  const urls = `${url}/Controller/Showtime/ajax.php`;
  const data = await fetch(urls, {
    method: "POST",
    body: JSON.stringify({
      Price: Price,
      StartTime: StartTime,
      MovieID: MovieID,
      EndTime: EndTime,
      RoomID: RoomID,
      FormatID: FormatID,
    }),
  });
  const datatorender = await data.json();
  return datatorender;
};
const getShowTimeByDateAndTheater = async (
  url,
  date = "2022-10-10",
  theaterid = "T001"
) => {
  const data = await fetch(
    `${url}/Controller/Showtime/ajax.php?action=getShowTimeByDateAndTheater&Theaterid=${theaterid}&date=${date}`,
    {
      method: "GET",
    }
  );
  const datatorender = await data.json();
  return datatorender;
};
export {
  getShowTimeByID,
  getAllShowTimesByDate,
  getShowTimeByDateAndGenre,
  getShowTimeByMovieandTheater,
  getAllShowtimeByMovieID,
  updateShowTime,
  addShowTime,
  removeShowTime,
  getShowTimeByDateAndTheater,
  getAllShowTime,
};
//   $movieid = $_GET['movieid'];
//   $date = $_GET['date'];
