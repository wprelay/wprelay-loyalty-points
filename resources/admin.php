<style>
    .heading {
        padding: 1rem 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }



    /* CSS */
    .button-6 {
        align-items: center;
        background-color: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: .25rem;
        box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
        box-sizing: border-box;
        color: rgba(0, 0, 0, 0.85);
        cursor: pointer;
        display: inline-flex;
        font-family: inherit;
        font-size: 16px;
        font-weight: 600;
        justify-content: center;
        line-height: .5;
        margin: 0;
        min-height: 1rem;
        padding: calc(.875rem - 1px) calc(1.5rem - 1px);
        position: relative;
        text-decoration: none;
        transition: all 250ms;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: baseline;
        width: auto;
    }

    .button-6:hover,
    .button-6:focus {
        border-color: rgba(0, 0, 0, 0.15);
        box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
        color: rgba(0, 0, 0, 0.65);
    }

    .button-6:hover {
        transform: translateY(-1px);
    }

    .button-6:active {
        background-color: #F0F0F1;
        border-color: rgba(0, 0, 0, 0.15);
        box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
        color: rgba(0, 0, 0, 0.65);
        transform: translateY(0);
    }

    .submit-area {
        margin: 1rem 0;
        display: flex;
        justify-content: end;
    }
</style>
<div class="wrap">
    <div id="wp-relay-lpoints-main">
        <h3 class="heading">WPLoyalty Points Conversion for WPRelay</h3>
        <!-- <form action="<?php echo $url ?>" method="POST"> -->
        <!--     <div class="filter-section"> -->
        <!--         <div> -->
        <!--             <label for="filter-name">Filter by Currency Name:</label> -->
        <!--             <input type="text" name="search" id="search" placeholder="Search for names.."> -->
        <!--         </div> -->
        <!--         <div> -->
        <!--             <button class="button-6">Filter</button> -->
        <!--         </div> -->
        <!--     </div> -->
        <!-- </form> -->

        <form action="" method="POST">
            <table id="currencyTable">
                <thead>
                    <tr>
                        <th>Currency Name</th>
                        <th>Currency Code</th>
                        <th>1 Unit</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $item) : ?>
                        <tr>
                            <td><?php echo $item['label'] ?></td>
                            <td><?php echo $item['currency_code'] ?></td>
                            <td><input type="number" value="1" readonly><?php echo $item['currency_code'] ?> </td>
                            <td><input name="points[<?php echo $item['currency_code'] ?>]" type="number" value="<?php echo $item['points'] ?>"></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <div class="submit-area">
                <button class="button-6">Update</button>
            </div>
        </form>


        <!-- <?php if (isset($pagination_data['show_pagination']) && $pagination_data['show_pagination']): ?> -->
        <!--     <div class="pagination"> -->
        <!--         <?php if (isset($pagination_data['previous_page']) && !empty($pagination_data['previous_page'])): ?> -->
        <!--             <a href="<?php echo $pagination_data['previous_page']['link'] ?>" class="prev">Previous</a> -->
        <!--         <?php endif; ?> -->
        <!---->
        <!--         <?php foreach ($pagination_data['pages'] as $page): ?> -->
        <!--             <a href="<?php echo esc_url($page['link']); ?>" class="<?php echo $pagination_data['current_page'] == $page['index'] ? 'active' : ''  ?>"> -->
        <!--                 <?php echo esc_html($page['index']); ?> -->
        <!--             </a> -->
        <!--         <?php endforeach ?> -->
        <!---->
        <!--         <?php if (isset($pagination_data['next_page']) && !empty($pagination_data['next_page'])): ?> -->
        <!--             <a href="<?php echo $pagination_data['next_page']['link'] ?>" class="prev">Next</a> -->
        <!--         <?php endif; ?> -->
        <!--     </div> -->
        <!-- <?php endif; ?> -->
    </div>
</div>
