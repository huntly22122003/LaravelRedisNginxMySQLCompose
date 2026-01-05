// resources/js/components/Success.jsx
import React from 'react';
import { Page, Card, Button, InlineStack } from '@shopify/polaris';

export default function Success({ shop, scope, accessToken, productsUrl, bulkshopifyUrl, ordersUrl }) {
  return (
    <Page title="App installed successfully! 🎉">
      <Card sectioned>
        <p><strong>Shop domain:</strong> {shop}</p>
        <p><strong>Scope:</strong> {scope}</p>
        <p><strong>Access Token:</strong> {accessToken}</p>
      </Card>

      <InlineStack gap="400" align="space-between">
        <Button primary url={productsUrl}>Go to Products Page</Button>
        <Button primary url={bulkshopifyUrl}>Go to Bulk Shopify Page</Button>
        <Button primary url={ordersUrl}>Go to Order Page</Button>
      </InlineStack>
    </Page>
  );
}