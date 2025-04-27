export async function getGenres() {
  const res = await fetch("/api/genres/get.php");
  return res.json();
}
