import { getFullPost } from "./blogs.js";
export { getHtmlPagination, giveNumPagination }


function getHtmlPagination($num_string, $totalCount) {
  $(".pagination").html("");
  console.log($num_string, $totalCount);

  if ($num_string === 0) {
    $num_string = 1;
  } else {
    $num_string += 1;
  }


  let $final = Math.ceil($totalCount / 10);
  let $result = "<div class='row'><div class='col'><div class='block-27'><ul>";
  let $i = 1;

  if ($num_string != 1) {
    // $result.= "<li><a href='{$this->response->getLink("posts.php", ["num" => $num_string-1])}'>&lt;</a></li> ";
    let $num = $num_string - 1;
    $result += `<li class='pagination-li' data-p='${$num}'><a href='#'>&lt;</a></li> `;
  }

  while ($i <= $final) {
    if ($i != $num_string) {
      // $result .= "<li><a href='{$this->response->getLink("posts.php", ["num" => $i])}'>$i</a></li> ";
      $result += `<li class='pagination-li' data-p='${$i}'><a href='#'>${$i}</a></li> `;
    } else {
      $result += `<li class='active'><span>${$i}</span></li> `;
    }
    $i++;
  };

  if ($num_string != $final) {
    // $result .= "<li><a href='{$this->response->getLink("posts.php", ["num" => $num_string+1])}'>&gt;</a></li>";
    let $num = $num_string + 1;
    $result += `<li class='pagination-li' data-p='${$num}'><a href='#'>&gt;</a></li>`;
  }

  $result += "</ul></div></div></div>";

  $(".pagination").append($result);
}

function giveNumPagination() { // вызывает страницу с постами смотря на номер страницы
  $('body').on("click", ".pagination-li", function () {
    let $page = Number($(this).attr("data-p"));

    getFullPost($page);
    let $url = `index.html?page=${$page}`;
    history.pushState({ page: $page }, "", $url);

  });
}