<div class="reply">
    <div class="heading">
        <h3 class="title">Leave A Reply</h3><!-- End .title -->
        <p class="title-desc">Your email address will not be published. Required fields are marked
            *</p>
    </div><!-- End .heading -->

    <form action="#">
        <label for="reply-message" class="sr-only">Comment</label>
        <textarea name="reply-message" id="reply-message" cols="30" rows="4" class="form-control" required
            placeholder="Comment *"></textarea>

        <div class="row">
            <div class="col-md-6">
                <label for="reply-name" class="sr-only">Name</label>
                <input type="text" class="form-control" id="reply-name" name="reply-name"
                    required placeholder="Name *">
            </div><!-- End .col-md-6 -->

            <div class="col-md-6">
                <label for="reply-email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="reply-email" name="reply-email"
                    required placeholder="Email *">
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->

        <button type="submit" class="btn btn-outline-primary-2">
            <span>POST COMMENT</span>
            <i class="icon-long-arrow-right"></i>
        </button>
    </form>
</div><!-- End .reply -->
