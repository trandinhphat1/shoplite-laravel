<?php $__env->startSection('scriptop'); ?>
<script>
    function validatePrice(input) {
        let value = parseFloat(input.value);
        if (isNaN(value) || value < 0) {
            input.value = 0;
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class='content'>
<?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Điều chỉnh giá
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-12 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <form method="post" action="<?php echo e(route('product.priceupdate')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($product->id); ?>" />

                <div class="intro-y box p-5">
                    <?php $__currentLoopData = $group_prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gprice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mt-3">
                        <label for="gp<?php echo e($gprice->id); ?>" class="form-label"><?php echo e($gprice->title); ?></label>
                        <input id="gp<?php echo e($gprice->id); ?>" 
                               name="gp<?php echo e($gprice->id); ?>" 
                               value="<?php echo e($gprice->price); ?>" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="mt-3">
                        <label for="old_price" class="form-label">Giá trước khuyến mãi</label>
                        <input id="old_price" 
                               name="old_price" 
                               value="<?php echo e($productextend->old_price); ?>" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>
                    
                    <div class="mt-3">
                        <label for="price" class="form-label">Giá chung hiện tại</label>
                        <input id="price" 
                               name="price" 
                               value="<?php echo e($product->price); ?>" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <label for="price_in" class="form-label">Giá nhập</label>
                        <input id="price_in" 
                               name="price_in" 
                               value="<?php echo e($product->price_in); ?>" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <label for="price_avg" class="form-label">Giá vốn trung bình</label>
                        <input id="price_avg" 
                               name="price_avg" 
                               value="<?php echo e($product->price_avg); ?>" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <label for="price_out" class="form-label">Giá bán</label>
                        <input id="price_out" 
                               name="price_out" 
                               value="<?php echo e($product->price_out); ?>" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
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
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\OneDrive\Máy tính\New folder (6)\shoplite-main\resources\views/backend/products/viewprice.blade.php ENDPATH**/ ?>