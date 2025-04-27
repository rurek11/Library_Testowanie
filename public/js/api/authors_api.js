export async function getAuthors() {
  const res = await fetch("/api/authors/get.php");
  return res.json();
}
