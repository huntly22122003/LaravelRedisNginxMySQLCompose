import React, { useEffect, useState } from "react";
import {
  Page,
  Card,
  DataTable,
  SkeletonBodyText,
  SkeletonDisplayText,
} from "@shopify/polaris";
import axios from "axios";

export default function WebHooksOrder() {
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get("/order-webhooks")
      .then(res => {
        console.log("ORDERS FROM API:", res.data);
        setOrders(res.data);
      })
      .finally(() => setLoading(false));
  }, []);

  const rows = orders.map(order => [
    `#${order.shopify_order_id}`,
    order.email ?? "-",
    `${order.total_price} ${order.currency}`,
    order.financial_status,
    order.received_at,
  ]);

  return (
    <Page title="Order Webhooks">
      <Card>
        {loading ? (
          <>
            <SkeletonDisplayText size="small" />
            <SkeletonBodyText lines={6} />
          </>
        ) : (
          <DataTable
            columnContentTypes={['text','text','text','text','text']}
            headings={[
              'Order ID',
              'Email',
              'Total',
              'Financial',
              'Received At'
            ]}
            rows={rows}
          />
        )}
      </Card>
    </Page>
  );
}
