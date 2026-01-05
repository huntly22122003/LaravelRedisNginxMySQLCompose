// resources/js/app.jsx
import React from 'react';
import { createRoot } from 'react-dom/client';
import { AppProvider, Frame } from '@shopify/polaris';
import '@shopify/polaris/build/esm/styles.css';
import { BrowserRouter, Routes, Route } from 'react-router-dom';

import Success from './components/success.jsx';
import ProductManager from './components/ProductIndex.jsx';
import WebHooksOrder from './components/WebHooksOrder.jsx';
import BulkImport from './components/BulkImport.jsx';
import BulkExport from './components/BulkExport.jsx';
//import ProductEdit from './components/ProductEdit.jsx';
const container = document.getElementById('app');

if (container) { // ✅ chỉ render khi container tồn tại
    const root = createRoot(container);

    const shop = container.dataset.shop;
    const scope = container.dataset.scope;
    const accessToken = container.dataset.accessToken;
    const productsUrl = container.dataset.productsUrl;
    const bulkshopifyUrl = container.dataset.bulkshopifyUrl;
    const ordersUrl = container.dataset.ordersUrl;
    const products = JSON.parse(container.dataset.products || '[]');
    const productstore = container.dataset.productsStore;
    const productedit = container.dataset.productsedit;
    const productupdate = container.dataset.productsUpdate;
    const softdelete = container.dataset.productsSoftdelete;
    const harddelete = container.dataset.productsHarddelete;
    const softdeleteData = JSON.parse(container.dataset.productsSoftdeleteproduct || '[]');
    const Variant = container.dataset.variants;
    const variantUpdate = container.dataset.variantsUpdate;
    const variantDelete = container.dataset.variantsDelete;
    const variantCreate = container.dataset.variantsCreate;
    const orderWebhooksIndex = container.dataset.ordersIndex;
    const bulkImportUrl = container.dataset.bulkImport;
    const bulkExportUrl = container.dataset.bulkExport;
    const bulkExportSearchUrl = container.dataset.bulkExportsearch;
    console.log('Shopify App Data:', { shop, scope, accessToken, productsUrl, bulkshopifyUrl, ordersUrl });
    console.log('Soft Delete Data:', softdeleteData);
    console.log('Variant URL:', Variant);
    console.log("Orders data:", orderWebhooksIndex);
    root.render(
        <AppProvider i18n={{}}> 
                <Frame>
        <Success
            shop={shop}
            scope={scope}
            accessToken={accessToken}
            productsUrl={productsUrl}
            bulkshopifyUrl={bulkshopifyUrl}
            ordersUrl={ordersUrl}
        />
        <ProductManager
        products={products}
        accessToken={accessToken}
        productstore={productstore}
        productedit={productedit}
        productupdate={productupdate}
        softdelete={softdelete}
        softDeleteData={softdeleteData}
        harddelete={harddelete}
        Variant={Variant}
        variantUpdate={variantUpdate}
        variantDelete={variantDelete}
        variantCreate={variantCreate}
        />

        <WebHooksOrder
          orders={orderWebhooksIndex}
        />
         <BulkImport
          bulkImportUrl={bulkImportUrl}
        />
        <BulkExport
          bulkExportUrl={bulkExportUrl}
            bulkExportSearchUrl={bulkExportSearchUrl}
        />
        </Frame>
        </AppProvider>
    );
} else {
  console.error('#app container not found');
}
