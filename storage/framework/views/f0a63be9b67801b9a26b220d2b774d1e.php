<?php $__env->startSection('scriptop'); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
 
<style>
     #thumbnail{
                                pointer-events: none;
                            }
                            #holder img{
                                border-radius: 0.375rem;
                                margin:0.2rem;
                            }
</style>
 
<script src="<?php echo e(asset('js/js/tom-select.complete.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('/js/css/tom-select.min.css')); ?>">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class = 'content'>
<?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Thêm hàng hóa
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-12 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <form method="post" action="<?php echo e(route('product.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="intro-y box p-5">
                    <div>
                        <label for="regular-form-1" class="form-label">Tiêu đề <span class="text-red-600">*</span></label>
                        <input id="title" name="title" type="text" class="form-control" placeholder="" value="<?php echo e(old('title')); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Photo <span class="text-red-600">*</span></label>
                        <div class="   ">
                            <div class="px-4 pb-4 mt-5 flex items-center  cursor-pointer relative">
                                <div   class="dropzone grid grid-cols-10 gap-5 pl-4 pr-5 py-5  "    url="<?php echo e(route('upload.product')); ?>" >
                                    <div class="fallback"> <input name="file" type="file" /> </div>
                                    <div class="dz-message" data-dz-message>
                                        <div class=" font-medium">Kéo thả hoặc chọn nhiều ảnh.</div>
                                            
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                         
                        <input type="hidden" id="photo" name="photo" required/>
                    </div>
                    
                    <div class="mt-3">
                        
                        <label for="" class="form-label">Mô tả ngắn <span class="text-red-600">*</span></label>
                       
                        <textarea  class="form-control"  name="summary" id="editor1"  required><?php echo e(old('summary')); ?></textarea>
                    </div>
                   
                    <div class="mt-3">
                        
                        <label for="" class="form-label">Mô tả <span class="text-red-600">*</span></label>
                       
                        <textarea class="editor" name="description" id="editor2"  required>
                            <?php echo e(old('description')); ?>

                        </textarea>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Giá nhập <span class="text-red-600">*</span></label>
                        <input id="price_in" name="price_in" type="number" class="form-control" value="<?php echo e(old('price_in', 0)); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Giá vốn trung bình <span class="text-red-600">*</span></label>
                        <input id="price_avg" name="price_avg" type="number" class="form-control" value="<?php echo e(old('price_avg', 0)); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Giá bán <span class="text-red-600">*</span></label>
                        <input id="price_out" name="price_out" type="number" class="form-control" value="<?php echo e(old('price_out', 0)); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Kích thước <span class="text-red-600">*</span></label>
                        <input id="size" name="size" type="text" class="form-control" placeholder=" " value="<?php echo e(old('size')); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Cân nặng <span class="text-red-600">*</span></label>
                        <input id="weight" name="weight" type="number" step="0.01" class="form-control" placeholder=" " value="<?php echo e(old('weight')); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Bảo hành <span class="text-red-600">*</span></label>
                        <input id="expired" name="expired" type="number" class="form-control" placeholder=" " value="<?php echo e(old('expired')); ?>" required>
                        <div class="form-help mt-3">
                            * Tính theo tháng
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="flex flex-col sm:flex-row items-center">
                            <label style="min-width:70px  " class="form-select-label" for="status">Danh mục <span class="text-red-600">*</span></label><br/>
                            <select name="cat_id"  class="form-select mt-2 sm:mr-2"   required>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value ="<?php echo e($cat->id); ?>" <?php echo e(old('cat_id') == $cat->id ? 'selected' : ''); ?> > <?php echo e($cat->title); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="flex flex-col sm:flex-row items-center">
                            <label style="min-width:100px  " class="form-select-label" for="status">Nhà sản xuất <span class="text-red-600">*</span></label><br/>
                            <select name="brand_id"  class="form-select mt-2 sm:mr-2"   required>
                                <option value =""> --chọn nhà sản xuất-- </option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value ="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id') == $brand->id ? 'selected' : ''); ?> > <?php echo e($brand->title); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="flex flex-col sm:flex-row items-center">
                            <label style="min-width:70px  " class="form-select-label"  for="status">Loại <span class="text-red-600">*</span></label>
                          
                            <select name="type" class="form-select mt-2 sm:mr-2"   required>
                                <option value ="normal" <?php echo e(old('type')=='normal'?'selected':''); ?>>Normal</option>
                                <!-- <option value = "inactive" <?php echo e(old('type')=='digital'?'selected':''); ?>>Digital</option> -->
                                <option value = "service" <?php echo e(old('type')=='service'?'selected':''); ?>>Service</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                     
                     <label for="post-form-4" class="form-label">Tags</label>
                     <select id="select-junk" name="tag_ids[]" multiple placeholder="Start Typing..." autocomplete="off">
                        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tag->id); ?>" <?php echo e(in_array($tag->id, old('tag_ids', [])) ? 'selected' : ''); ?> ><?php echo e($tag->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                    
             </div>     
                    <div class="mt-3">
                        <div class="flex flex-col sm:flex-row items-center">
                            <label style="min-width:70px  " class="form-select-label"  for="status">Tình trạng <span class="text-red-600">*</span></label>
                           
                            <select name="status" class="form-select mt-2 sm:mr-2"   required>
                                <option value ="active" <?php echo e(old('status')=='active'?'selected':''); ?>>Active</option>
                                <option value = "inactive" <?php echo e(old('status')=='inactive'?'selected':''); ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>    <?php echo e($error); ?> </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
 <script>
    var select = new TomSelect('#select-junk',{
        maxItems: null,
        allowEmptyOption: true,
        plugins: ['remove_button'],
        sortField: {
            field: "text",
            direction: "asc"
        },
        onItemAdd:function(){
                this.setTextboxValue('');
                this.refreshOptions();
            },
        create: true
        
    });
    select.clear();
</script>
<script>
 
                // previewsContainer: ".dropzone-previews",
    Dropzone.instances[0].options.multiple = true;
    Dropzone.instances[0].options.autoQueue= true;
    Dropzone.instances[0].options.maxFilesize =  1; // MB
    Dropzone.instances[0].options.maxFiles =5;
    Dropzone.instances[0].options.dictDefaultMessage = 'Drop images anywhere to upload (6 images Max)';
    Dropzone.instances[0].options.acceptedFiles= "image/jpeg,image/png,image/gif";
    Dropzone.instances[0].options.previewTemplate =  '<div class="col-span-5 md:col-span-2 h-28 relative image-fit cursor-pointer zoom-in">'
                                               +' <img    data-dz-thumbnail >'
                                               +' <div title="Xóa hình này?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"> <i data-lucide="octagon"   data-dz-remove> x </i> </div>'
                                           +' </div>';
    // Dropzone.instances[0].options.previewTemplate =  '<li><figure><img data-dz-thumbnail /><i title="Remove Image" class="icon-trash" data-dz-remove ></i></figure></li>';      
    Dropzone.instances[0].options.addRemoveLinks =  true;
    Dropzone.instances[0].options.headers= {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
 
    Dropzone.instances[0].on("addedfile", function (file ) {
        // Example: Handle success event
        console.log('File addedfile successfully!' );
    });
    Dropzone.instances[0].on("success", function (file, response) {
        // Example: Handle success event
        // file.previewElement.innerHTML = "";
        if(response.status == "true")
        {
            var value_link = $('#photo').val();
            if(value_link != "")
            {
                value_link += ",";
            }
            value_link += response.link;
            $('#photo').val(value_link);
        }
           
        // console.log('File success successfully!' +$('#photo').val());
    });
    Dropzone.instances[0].on("removedfile", function (file ) {
            $('#photo').val('');
        console.log('File removed successfully!'  );
    });
    Dropzone.instances[0].on("error", function (file, message) {
        // Example: Handle success event
        file.previewElement.innerHTML = "";
        console.log(file);
       
        console.log('error !' +message);
    });
     console.log(Dropzone.instances[0].options   );
 
    // console.log(Dropzone.optionsForElement);
 
</script>
<!-- <script src="<?php echo e(asset('backend/assets/dist/js/ckeditor-classic.js')); ?>"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script> -->
<script src="<?php echo e(asset('js/js/ckeditor.js')); ?>"></script>
<script>
        // CKSource.Editor
        ClassicEditor.create( document.querySelector( '#editor2' ), 
        {
            ckfinder: {
                uploadUrl: '<?php echo e(route("upload.ckeditor")."?_token=".csrf_token()); ?>'
                },
                mediaEmbed: {previewsInData: true}
        })
        .then( editor => {
            console.log( editor );
        })
        .catch( error => {
            console.error( error );
        })

</script>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\OneDrive\Máy tính\New folder (6)\shoplite-main\resources\views/backend/products/create.blade.php ENDPATH**/ ?>