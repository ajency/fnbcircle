<div class="browse-cat list-of-business">
   <h6 class="element-title">FnB Circle also has business listings</h6>
   <span class="text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit, doloribus.</span>
   <ul class="browse-cat__list m-t-20"> 


      <?php  foreach($data['browse_categories'] as $category) { ?> 
      <li>
         <a href="<?php echo $category['url'] ; ?>"  title="Browse for <?php echo $category['name'];?> category in <?php echo $data['city']['name'] ;?> ">
            <p class="m-b-0 flex-row">
               <span class="fnb-icons cat-icon">
                  <img src="<?php echo $category['image']; ?>">
               </span>
                <?php echo $category['name']; ?> <span class="total p-l-5 bolder">(<?php echo $category['count']; ?>)</span>
            </p>
         </a>
      </li> 
        
      <?php } ?>
      <!-- <li>
         <a href="">
            <p class="m-b-0 flex-row">
               <span class="fnb-icons cat-icon veg">
                  <!- - <img src="img/veg-option.png"> - ->
               </span>
               Vegetables <span class="total p-l-5 bolder">(218)</span>
            </p>
         </a>
      </li>
      <li>
         <a href="">
            <p class="m-b-0 flex-row">
               <span class="fnb-icons cat-icon drinks"></span>
               Cold Drinks <span class="total p-l-5 bolder">(28)</span>
            </p>
         </a>
      </li>
      <li>
         <a href="">
            <p class="m-b-0 flex-row">
               <span class="fnb-icons cat-icon grocery"></span>
               Grocery <span class="total p-l-5 bolder">(56)</span>
            </p>
         </a>
      </li>
      <li>
         <a href="">
            <p class="m-b-0 flex-row">
               <span class="fnb-icons cat-icon drinks"></span>
               Cold Drinks <span class="total p-l-5 bolder">(28)</span>
            </p>
         </a>
      </li> -->
   </ul>
</div>