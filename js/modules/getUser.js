export { getUser };

function getUser($onePostObject, number) { // HTML код для КАЖДОГО отображение поста на странице БЛОГИ и ГЛАВНАЯ
    console.log($onePostObject);
    const el = `<tr>
    <th scope="row">${number}</th>
    <td>${$onePostObject.model.name}</td>
    <td>${$onePostObject.model.surname}</td>
    <td>${$onePostObject.model.login}</td>
    <td>${$onePostObject.model.email}</td>
    <td>` + ($onePostObject.dateEnd ? `${$onePostObject.dateEnd}` : "") + `</td>
    <td>
    <a href="#" data-user-id='${$onePostObject.model.id}' class="btn btn-outline-warning px-4">⏳ Block</a>
    </td>
    <td>
    <a href="#" data-user-id='${$onePostObject.model.id}' class="btn btn-outline-danger px-4">📌 Block</a>
    </td>
    </tr>`;
    return el;
}