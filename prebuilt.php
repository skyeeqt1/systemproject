<?php
    session_start();
    include_once './assets/includes/dbh.inc.php';
    require_once './assets/includes/functions.inc.php'; // Include necessary functions

    // Get filter data from the form
    $priceMin = isset($_GET['priceMin']) ? intval($_GET['priceMin']) : null;
    $priceMax = isset($_GET['priceMax']) ? intval($_GET['priceMax']) : null;
    $brandIDs = isset($_GET['brand']) ? array_map('intval', $_GET['brand']) : [];
    $productTypeIDs = isset($_GET['productType']) ? array_map('intval', $_GET['productType']) : [];
    $tagIDs = isset($_GET['tag']) ? array_map('intval', $_GET['tag']) : [];

    // Prepare price range
    $priceRange = null;
    if ($priceMin !== null && $priceMax !== null) {
        $priceRange = ['min' => $priceMin, 'max' => $priceMax];
    }

    // Fetch filtered products
    $filteredProducts = getFilteredProducts($conn, $priceRange, $brandIDs, $productTypeIDs, $tagIDs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/budgetPC.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php
        include_once 'header.php';
    ?>

    
    <div class="container pt-3">
        <div class="row">
            <div class="col-12 p-4 align-content-end" style="min-height: 200px; border-radius: 20px; background-image: linear-gradient(rgba(8, 20, 41, 0.7), rgba(8, 20, 41, 0.6)), url('assets/img/prebuilt.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h2 class="text-left text-white">Choose, plug and play</h2>
                <p class="text-white">
                    Select the pre-built PC that suits your needs.
                <p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 filter p-0">
                <form id="filterForm" class="row gap-3 m-0">
                    
                    <div class="filter-card col m-0">
                        <h3>Price</h3>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="0-19999" class="price-filter"> ₱0 - ₱19999
                        </div>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="20000-39999" class="price-filter"> ₱20000 - ₱39999
                        </div>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="40000-69999" class="price-filter"> ₱40000 - ₱69999
                        </div>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="70000" class="price-filter"> ₱70000+
                        </div>
                    </div>

                    <div class="filter-card col m-0">
                        <h3>Brand</h3>
                        <div class="row m-0">
                            <?php
                            $brands = getBrands($conn); // Fetch brands from the database
                            foreach ($brands as $brand):
                            ?>
                                <div class="form-check col-4">
                                    <input class="form-check-input" type="checkbox" name="brand[]" value="<?= $brand['BrandID'] ?>" id="brand<?= $brand['BrandID'] ?>">
                                    <label class="form-check-label" for="brand<?= $brand['BrandID'] ?>">
                                        <?= htmlspecialchars($brand['BrandName']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                    </div>

                    <div class="filter-card col m-0">
                        <h3>Type</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="productType[]" value="11" id="type11">
                            <label class="form-check-label" for="type<?= $type['ProductTypeID'] ?>">Prebuilt PC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="productType[]" value="11" id="type12">
                            <label class="form-check-label" for="type<?= $type['ProductTypeID'] ?>">Laptop</label>
                        </div>
                    </div>

                    <div class="filter-card col m-0">
                        <h3>Classification</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="1" id="tag1">
                            <label class="form-check-label" for="tag1">High-end</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="2" id="tag2">
                            <label class="form-check-label" for="tag2">Mid-end</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="3" id="tag3">
                            <label class="form-check-label" for="tag3">Low-end</label>
                        </div>
                    </div>
                   
                    <!-- <button type="submit" class="btn btn-primary">Apply Filters</button> -->
                </form>
            </div>
            <div class="col-md-12 products">
                <div id="productContainer" class="row">
                    
                   
                </div>
               
                
                </div>
            </div>
        </div>
                        
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updatePriceLabel(value) {
            document.getElementById('priceLabel').textContent = value;
        }

        function fetchFilteredProducts() {
        const formData = $('#filterForm').serialize(); // Serialize form data

            $.ajax({
                url: 'filterPrebuiltAjax.php', // Backend script for filtering
                method: 'GET',
                data: formData,
                success: function(response) {
                    $('#productContainer').html(response); // Update the product container
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

    // Attach event listeners to filter inputs
    $('#filterForm').on('change', 'input', function() {
        fetchFilteredProducts(); // Fetch products when any filter changes
    });

    // Initial fetch
    $(document).ready(function() {
        fetchFilteredProducts();
    });
    </script>


</body>
</html>
