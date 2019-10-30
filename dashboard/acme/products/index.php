<?php
/*
Products Controller 
*/
// Get the database connection file
 require_once '../library/connections.php';
 // Get the acme model for use as needed
 require_once '../model/acme-model.php';
 
 require_once '../model/products-model.php';

 // Get the array of categories
$categories = getCategories();
// Get the array of categories ID
$categoriesID = getCategoriesID();


// Create an array to save the names for indexes in order to create the select option
$indexCatIDtryarray = 0;
$catNames = array();
$navList = '<ul>';
 $navList .= "<li><a href='/acme/index.php' title='View the Acme home page'>Home</a></li>";
 foreach ($categories as $category) {
  $navList .= "<li><a href='/acme/index.php?action=".urlencode($category['categoryName'])."' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
     //save the names in the array
    $catNames[$indexCatIDtryarray] = urlencode($category['categoryName']);
     //increment the index
     $indexCatIDtryarray = $indexCatIDtryarray + 1;
 }
 $navList .= '</ul>';
 //echo $navList;
 //exit;
// reset the index
$indexCatIDtryarray = 0;
$catList = '<select name="categoryId" id="categoryId">';
 $catList .= '<option value="empty">Choose a Category</option>';
 foreach ($categoriesID as $categoryID) {
     $catList .= '<option value="'.urlencode($categoryID['categoryId']).'">'.$catNames[$indexCatIDtryarray].'</option>';
     //use the array to write the name according the index, in the sql they use the same class of organization
     $indexCatIDtryarray = $indexCatIDtryarray + 1;
 }
 $catList .= '</select>';
//echo $catList;
//exit;

 $action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
  
  if ($action == NULL){
      $action = 'products';
   
  }
  if($action == 'newCategory.php'){
          $action = 'newCategory';
    }
   
  if($action == 'newProduct.php'){
          $action = 'newProduct';
    }
  
  
  
  }
 switch ($action){
   case 'products':
       include '../view/products.php';
   break;
   case 'newCategory':
       include '../view/newCategory.php';
    break;  
   case 'newProduct':
       include '../view/newProduct.php';
    break;  
      
}
 switch ($action){
   case 'cat':
    $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
    
    // Check for missing data
    if(empty($categoryName)){
        echo '<div class ="big"><p>Please provide information for all empty form fields</p></div>';
        include '../view/newCategory.php';
        exit;
    } 
   // Send the data to the model
    $regOutcome = addNewCategory($categoryName);
    // Check and report the result 
     
    if($regOutcome === 1){
        echo '<div class="big"><p> Thanks for registering the new category.</p></div>';
        include '../view/newCategory.php';
        exit;
    } else 
    {
        
        $message = '<p>Registration failed. Please try again. </p>';
        include '../view/newCategory.php';
        exit;
    
    }
        
    break;
   
   case 'prod':
    $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
    $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
    $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
    $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
    $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //$invPrice = checkPrice($invPrice);
    $invStock =filter_input(INPUT_POST, 'invStock');
    $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //$invSize = checkFloat($invSize);
    $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //$invWeight = checkFloat($invWeight);
    $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
    $categoryId = filter_input(INPUT_POST, 'categoryId');
    $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
    $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
   
// Check for missing data
    //$categoryId = NULL;
    
    if(empty($invName)|| empty($invDescription)|| empty($invImage) || empty($invThumbnail)|| empty($invPrice)|| empty($invStock)|| empty($invSize)|| empty($invWeight)|| empty($invLocation)||empty($categoryId)|| empty($invVendor)||empty($invStyle)){
        
        
        
        echo '<div class ="big"><p>Please provide information for all empty form fields</p></div>';
        include '../view/newProduct.php';
        
        exit;
        } 
   // Send the data to the model
   
   $regOutcome1 = addProd($categoryId, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle);
    // Check and report the result 
   
    if($regOutcome1 === 1){
        echo '<div class="big"><p> New Product has been added to your inventory</p></div>';
        include '../view/newProduct.php';
        exit;
    } 
    else {
        
        $message = '<p>Sorry, but the information failed. Please try again. </p>';
        include '../view/newCategory.php';
        
        exit;
    
    }
        
    break;
 
     			                          
}

?>