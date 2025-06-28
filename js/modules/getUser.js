export { getUser };

function getUser($onePostObject, number) { // HTML код для КАЖДОГО отображение поста на странице БЛОГИ и ГЛАВНАЯ

    const el = `<tr>
    <th scope="row">${number}</th>
    <td>${$onePostObject.name}</td>
    <td>${$onePostObject.surname}</td>
    <td>${$onePostObject.login}</td>
    <td>${$onePostObject.email}</td>
    <td>` + ($onePostObject.__user_ban ? `${$onePostObject.__user_ban}` : "") + `</td>
    <td>
    <a href="#" data-user-id='${$onePostObject.id}' class="btn btn-outline-warning px-4">⏳ Block</a>
    </td>
    <td>
    <a href="#" data-user-id='${$onePostObject.id}' class="btn btn-outline-danger px-4">📌 Block</a>
    </td>
    </tr>`;
    return el;
}