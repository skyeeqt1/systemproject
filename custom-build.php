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
    <link rel="stylesheet" href="assets/css/budgetPC.css">
</head>

<body>
    <?php
        include_once 'header.php';
    ?>

    <h2>All Products</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-3 filter">
                <form id="filterForm">
                    
                    <div class="filter-card">
                        <h3>Price</h3>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="100-199" class="price-filter"> $100 - $199
                        </div>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="200-299" class="price-filter"> $200 - $299
                        </div>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="300-399" class="price-filter"> $300 - $399
                        </div>
                        <div>
                            <input type="checkbox" name="priceRange[]" value="400+" class="price-filter"> $400+
                        </div>
                    </div>

                    <div class="filter-card">
                        <h3>Brand</h3>
                        <?php
                            $brands = getBrands($conn); // Fetch brands from the database
                            foreach ($brands as $brand) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" name="brand[]" value="' . $brand['BrandID'] . '" id="brand' . $brand['BrandID'] . '">';
                                echo '<label class="form-check-label" for="brand' . $brand['BrandID'] . '">' . $brand['BrandName'] . '</label>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="filter-card">
                        <h3>Components</h3>
                        <?php
                            $productTypes = getProductTypes($conn); // Fetch product types from the database
                            foreach ($productTypes as $type) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" name="productType[]" value="' . $type['ProductTypeID'] . '" id="type' . $type['ProductTypeID'] . '">';
                                echo '<label class="form-check-label" for="type' . $type['ProductTypeID'] . '">' . $type['ProductTypeName'] . '</label>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="filter-card">
                        <h3>Tags</h3>
                        <?php
                            $tags = getTags($conn); // Fetch tags from the database
                            foreach ($tags as $tag) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" name="tag[]" value="' . $tag['TagID'] . '" id="tag' . $tag['TagID'] . '">';
                                echo '<label class="form-check-label" for="tag' . $tag['TagID'] . '">' . $tag['TagName'] . '</label>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </div>
            <div class="col-md-9 products">
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
                url: 'filterProductsAjax.php', // Backend script for filtering
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
