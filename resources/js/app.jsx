import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import {
  AppProvider,
  Frame,
  Navigation,
} from '@shopify/polaris';
import '@shopify/polaris/build/esm/styles.css';

import Success from './components/success.jsx';
import ProductManager from './components/ProductIndex.jsx';
import WebHooksOrder from './components/WebHooksOrder.jsx';
import BulkImport from './components/BulkImport.jsx';
import BulkExport from './components/BulkExport.jsx';

const container = document.getElementById('app');

if (!container) {
  console.error('#app container not found');
} else {
  const root = createRoot(container);
  const data = container.dataset;

  const products = JSON.parse(data.products || '[]');
  const softDeleteData = JSON.parse(
    data.productsSoftdeleteproduct || '[]'
  );

  const VIEWS = {
    HOME: 'home',
    PRODUCTS: 'products',
    ORDERS: 'orders',
    BULK_IMPORT: 'bulk_import',
    BULK_EXPORT: 'bulk_export',
  };

  function App() {
    const [view, setView] = useState(VIEWS.HOME);

    const renderView = () => {
      switch (view) {
        case VIEWS.PRODUCTS:
          return (
            <ProductManager
              products={products}
              accessToken={data.accessToken}
              productstore={data.productsStore}
              productedit={data.productsedit}
              productupdate={data.productsUpdate}
              softdelete={data.productsSoftdelete}
              harddelete={data.productsHarddelete}
              softDeleteData={softDeleteData}
              Variant={data.variants}
              variantUpdate={data.variantsUpdate}
              variantDelete={data.variantsDelete}
              variantCreate={data.variantsCreate}
            />
          );

        case VIEWS.ORDERS:
          return <WebHooksOrder orders={data.ordersIndex} />;

        case VIEWS.BULK_IMPORT:
          return <BulkImport bulkImportUrl={data.bulkImport} />;

        case VIEWS.BULK_EXPORT:
          return (
            <BulkExport
              bulkExportUrl={data.bulkExport}
              bulkExportSearchUrl={data.bulkExportsearch}
            />
          );

        default:
          return (
            <Success
              shop={data.shop}
              scope={data.scope}
              accessToken={data.accessToken}
              productsUrl={data.productsUrl}
              bulkshopifyUrl={data.bulkshopifyUrl}
              ordersUrl={data.ordersUrl}
            />
          );
      }
    };

    return (
      <AppProvider i18n={{}}>
        <Frame
          navigation={
            <Navigation location={view}>
              <Navigation.Section
                items={[
                  { label: 'Home', onClick: () => setView(VIEWS.HOME) },
                  { label: 'Products', onClick: () => setView(VIEWS.PRODUCTS) },
                  { label: 'Orders Webhook', onClick: () => setView(VIEWS.ORDERS) },
                  { label: 'Bulk Import', onClick: () => setView(VIEWS.BULK_IMPORT) },
                  { label: 'Bulk Export', onClick: () => setView(VIEWS.BULK_EXPORT) },
                ]}
              />
            </Navigation>
          }
        >
          {renderView()}
        </Frame>
      </AppProvider>
    );
  }

  root.render(<App />);
}
