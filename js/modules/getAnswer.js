export { getAnswer };

function getAnswer($oneCommentObject) {
    const el = `<h2 class="h3">Ответ пользователю:</h3>
                <div class="row block-9">
                    <div class="col-lg-6 d-flex">
                        <form enctype="multipart/form-data" action="" method="post" class="bg-light p-5 contact-form">
    
    
                            <div class="form-group">
                                <textarea name="message" id="content" cols="30" rows="10" class="form-control"
                                    placeholder="Answer" name="content"></textarea>
                                <div class="invalid-feedback">
                                </div>
                            </div>
    
    
                            <div class="form-group">
                                <input type="submit" data-post='${$oneCommentObject}' data-com='${$oneCommentObject}' value="Ответить" class="btn btn-primary py-3 px-5 answer-button">
                            </div>
                        </form>
    
                    </div>`;
    return el;
}