1. Admin DashBoard is the dashboard page
2. URL_INSTALL to load access_token into database then callback->admin
3. Shopify_After_Add is Create product
4. Variant use $ProductId => show all Variant $ProductId
5. Soft Delete put a flag into database, Hard Delete call Destroy in shopify and delete flag in database.
6. Shopify_Before_Add_SoftDelete ->Shopify_After_SoftDelete-> Shopify_After_SoftDelete_Show2 -> Shopify_After_HardDelete
7. Shopify_Before_Search -> Shopify_After_Search -> Shopify_After_Search_2
8. Shopify_Add_Import-> Shopify_After_Import. ADD JSON SCRIPT into shopify product
9. Webhooks is automatic notice then store in database when Order is done from customer. Shopify_Add_Order -> Shopify_After_AddOrder
10. Shopify_Create_Variant -> Shopify_After_Create_Variant -> Shopify_After_Edit_Variant.
11. Logic is Show Variant render with $ProductID, $Edit with render $ProductID and $VariantID