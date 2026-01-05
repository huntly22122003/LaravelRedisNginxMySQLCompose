// resources/js/components/BulkImport.jsx
import React, { useState } from "react";
import {
  Page,
  Card,
  TextField,
  Button,
  BlockStack,
  InlineStack,
  SkeletonBodyText,
  SkeletonDisplayText,
  Toast,
} from "@shopify/polaris";
import axios from "axios";

export default function BulkImport({ bulkImportUrl }) {
  const [productsJson, setProductsJson] = useState("");
  const [loading, setLoading] = useState(false);
  const [toast, setToast] = useState(null);

  const handleImport = async () => {
    try {
      JSON.parse(productsJson);
    } catch {
      setToast({ content: "Invalid JSON format", error: true });
      return;
    }

    setLoading(true);
    try {
      await axios.post("/bulk/products/import", {
        products: productsJson,
      });

      setToast({ content: "Import successful" });
      setProductsJson("");
    } catch {
      setToast({ content: "Import failed", error: true });
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Page title="Bulk Shopify Import">
        <Card sectioned>
          {loading ? (
            <>
              <SkeletonDisplayText size="small" />
              <SkeletonBodyText lines={6} />
            </>
          ) : (
            <BlockStack gap="3">
              <TextField
                label="Products JSON"
                multiline={8}
                value={productsJson}
                onChange={setProductsJson}
                placeholder='[{"title":"Product 1","vendor":"Vendor A"}]'
              />

              <InlineStack gap="3">
                <Button primary onClick={handleImport}>
                  Import Products
                </Button>
              </InlineStack>
            </BlockStack>
          )}
        </Card>
      </Page>

      {toast && (
        <Toast
          content={toast.content}
          error={toast.error}
          onDismiss={() => setToast(null)}
        />
      )}
    </>
  );
}