import http from "k6/http";
import { check, sleep } from "k6";

const BASE_URL = "http://localhost:8000/api/books";
const createdIds = [];

export const options = {
  scenarios: {
    ramping_load_test: {
      executor: "ramping-arrival-rate",
      startRate: 10,
      timeUnit: "1s",
      preAllocatedVUs: 100,
      maxVUs: 5000,
      stages: [
        { target: 100, duration: "5s" },
        { target: 200, duration: "5s" },
        { target: 400, duration: "5s" },
        { target: 800, duration: "5s" },
        { target: 1600, duration: "5s" },
        { target: 3200, duration: "10s" },
        { target: 5000, duration: "30s" },
        { target: 0, duration: "10s" },
      ],
    },
  },
};

function randomTitle() {
  return "Test Book " + Math.random().toString(36).substring(7);
}

export default function () {
  const action = Math.random();

  if (action < 0.25) {
    // GET all books
    const res = http.get(BASE_URL + "/get.php");
    check(res, {
      "GET status is 200": (r) => r.status === 200,
    });
  } else if (action < 0.5) {
    // POST new book
    const payload = {
      title: randomTitle(),
      author_id: 1,
      year: 2023,
      genre_id: 1,
    };
    const res = http.post(BASE_URL + "/post.php", JSON.stringify(payload), {
      headers: { "Content-Type": "application/json" },
    });
    const json = res.json();
    if (res.status === 201 && json?.id) {
      createdIds.push(json.id);
    }
    check(res, {
      "POST status is 201": (r) => r.status === 201,
    });
  } else if (action < 0.75 && createdIds.length > 0) {
    // PUT update existing book
    const id = createdIds[Math.floor(Math.random() * createdIds.length)];
    const res = http.put(
      BASE_URL + "/put.php",
      JSON.stringify({
        id,
        title: "Updated " + randomTitle(),
        author_id: 1,
        year: 2022,
        genre_id: 1,
      }),
      {
        headers: { "Content-Type": "application/json" },
      }
    );
    check(res, {
      "PUT status is 200": (r) => r.status === 200,
    });
  } else if (createdIds.length > 0) {
    // DELETE existing book
    const id = createdIds.pop();
    const res = http.del(BASE_URL + "/delete.php", JSON.stringify({ id }), {
      headers: { "Content-Type": "application/json" },
    });
    check(res, {
      "DELETE status is 200 or 404": (r) =>
        r.status === 200 || r.status === 404,
    });
  }

  sleep(1);
}
