
<div class="content-wrapper">
    <div class="container">
        <h3 class="p-3">Categories</h3>
        <section class="connectedSortable">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <!-- Category Title -->
                    </h3>
                </div>
                <form method="post" enctype="multipart/form-data" action="">
                    <div class="row clearfix m-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- Name Input -->
                            <div class="form-group">
                                <label for="category_name">Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required />
                            </div>

                            <!-- Description Input -->
                            <div class="form-group">
                                <label for="category_description">Description</label>
                                <textarea class="form-control" id="category_description" name="category_description"></textarea>
                            </div>

                            <!-- Category Image Input -->
                            <div class="form-group">
                                <label for="category_image">Category Image</label>
                                <input type="file" class="form-control" id="category_image" name="category_image" required />
                            </div>

                            <!-- Image Preview -->
                            <img alt="category_image" src="" id="img_loader" style="
                  border-radius: 5%;
                  border-color: grey;
                  border-style: solid;
                  height: auto;
                  width: 60%;
                " />
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>