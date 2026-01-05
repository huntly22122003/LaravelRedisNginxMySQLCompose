import React, { useEffect, useState } from "react";
import {
  Page,
  Card,
  DataTable,
  SkeletonBodyText,
  SkeletonDisplayText,
  TextField,
  Button,
  InlineStack,
} from "@shopify/polaris";
import axios from "axios";

export default function BulkExport({ bulkExportUrl, bulkExportSearchUrl }) {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [keyword, setKeyword] = useState("");
  const [limit, setLimit] = useState(10);

  /**
   * fetchProducts
   * - Nếu keyword trống → gọi export
   * - Nếu keyword có → gọi search
   */
  const fetchProducts = () => {
    setLoading(true);

    const url = keyword.trim() === "" ? bulkExportUrl : bulkExportSearchUrl;

    console.log("CALL URL:", url, { q: keyword, limit });

    axios
      .get(url, { params: { q: keyword, limit } })
      .then((res) => {
        let data = [];
        if (Array.isArray(res.data)) data = res.data;
        else if (Array.isArray(res.data.products)) data = res.data.products;
        else if (Array.isArray(res.data.data)) data = res.data.data;

        setProducts(data);
      })
      .catch((err) => {
        console.error("EXPORT/SEARCH ERROR:", err);
        setProducts([]);
      })
      .finally(() => setLoading(false));
  };

  // 🔹 Load lần đầu → export
  useEffect(() => {
    fetchProducts();
  }, []);
  const rows = products.map((product) => [
    product.id,
    product.title,
    product.vendor ?? "-",
    product.variants?.[0]?.price ?? "N/A",
  ]);

  return (
    <Page title="Bulk Export Products">
      {/* 🔍 SEARCH BAR */}
      <Card sectioned>
        <InlineStack gap="300" align="start">
          <TextField
            label="Search"
            value={keyword}
            onChange={setKeyword}
            placeholder="Search by title or vendor"
          />

          <TextField
            label="Limit"
            type="number"
            value={limit}
            onChange={setLimit}
            min={1}
            max={250}
          />

          <Button primary onClick={fetchProducts}>
            Search
          </Button>
        </InlineStack>
      </Card>

      {/* 📦 DATA TABLE */}
      <Card sectioned>
        {loading ? (
          <>
            <SkeletonDisplayText size="small" />
            <SkeletonBodyText lines={6} />
          </>
        ) : rows.length > 0 ? (
          <DataTable
            columnContentTypes={["text", "text", "text", "text"]}
            headings={["ID", "Title", "Vendor", "Price"]}
            rows={rows}
          />
        ) : (
          <p style={{ padding: 16 }}>No products found.</p>
        )}
      </Card>
    </Page>
  );
}
