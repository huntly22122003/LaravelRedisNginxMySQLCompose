// resources/js/components/ProductIndex.jsx
import React, { useState } from 'react';
import {
  Page,
  Card,
  TextField,
  Button,
  ResourceList,
  ResourceItem,
  InlineStack,
} from '@shopify/polaris';

export default function ProductManager({ products, accessToken, productstore, productedit, productupdate, softdelete, softDeleteData, harddelete, Variant, variantUpdate, variantDelete, variantCreate   }) {
  const [editingId, setEditingId] = useState(null);
  const [title, setTitle] = useState('');
  const [price, setPrice] = useState('');
  const [editingProducttitle, setEditingProductTitle] = useState('');
  const [editingProductprice, setEditingProductPrice] = useState('');
  const [showSoftDelete, setShowSoftDelete] = useState(false);
  const [showVariantCard, setShowVariantCard] = useState(false);
  const [variantCreateOpen, setVariantCreateOpen] = useState(false);// Biến trạng thái để mở form tạo variant
  const [variantData, setVariantData] = useState([]);
  const [variantProductId, setVariantProductId] = useState(null);
  const [editingVariantId, setEditingVariantId] = useState(null);
  const [editingVariantTitle, setEditingVariantTitle] = useState('');
  const [editingVariantPrice, setEditingVariantPrice] = useState('');
  const [editingVariantOption1, setEditingVariantOption1] = useState('');
  const [editingVariantSku, setEditingVariantSku] = useState('');

  const fetchVariants = async (productId) => {
  try {
    const url = Variant.replace('/0', `/${productId}`);
    console.log('Final Variant URL:', url); 
    const res = await fetch(
      url,
      {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
      }
    );
    const data = await res.json();
    console.log('Response data:', data);
    console.log('Response status:', res.status);
    setVariantData(data.variants);
    console.log('variantData set to:', data.variants);
    setVariantProductId(productId);
    setShowVariantCard(true);
  } catch (err) {
    console.error(err);
  }
};
  return (
    <Page title="Shopify Products">
      <Card sectioned>
        <p><strong>Access Token:</strong> {accessToken}</p>
        <form method="POST" action={productstore}>
          <input type="hidden" name="_token" value={window.csrfToken} />
          <TextField label="Product Title" name="title" value={title} onChange={setTitle} required />
          <TextField label="Price" name="price" value={price} onChange={setPrice} required />
          <Button submit primary>Add Product</Button>
        </form>
      </Card>

      <Card title="Product List" sectioned>
        <ResourceList
          resourceName={{ singular: 'product', plural: 'products' }}
          items={products}
          renderItem={(item) => {
            const { id, title, variants } = item;
            const price = variants?.[0]?.price || 'N/A';
            let productId;
              if (typeof id === 'string') {
                // Nếu id là GID string
                productId = id.split('/').pop();
              } else if (typeof id === 'number') {
                // Nếu id là số nguyên
                productId = id.toString();
              } else {
                // Nếu không có id
                productId = null;
              }

            return (
              <ResourceItem id={productId} accessibilityLabel={`View details for ${title}`}>
                {editingId === productId ? (
                  // 🔄 Nếu đang edit thì render form edit ngay trong card
                  <form method="POST" action={productupdate}>
                    <input type="hidden" name="_token" value={window.csrfToken} />
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="id" value={productId} /> {/* Hidden input để gửi ID */}
                    <p><strong>ID:</strong> {productId}</p>
                    <TextField label="Title" name="title" value={editingProducttitle} onChange={setEditingProductTitle} required />
                    <TextField label="Price" name="price" value={editingProductprice} onChange={setEditingProductPrice} required />
                    <InlineStack gap="200">
                      <Button submit primary>Save</Button>
                      <Button onClick={() => setEditingId(null)}>Cancel</Button>
                    </InlineStack>
                  </form>
                ) : (
                  // ✅ Nếu không edit thì render thông tin sản phẩm
                  <>
                    <h3>{title}</h3>
                    <p>Price: {price}</p>
                    <InlineStack gap="200">
                      <Button onClick={() => setEditingId(productId)}>Edit</Button>
                      <form method="POST" action={softdelete}>
                        <input type="hidden" name="_token" value={window.csrfToken} />
                        <input type="hidden" name="id" value={productId} />
                        <input type="hidden" name="_method" value="DELETE" />
                        <Button destructive submit>Soft Delete</Button>
                      </form>
                      <Button onClick={() => fetchVariants(productId)}>Show Variant Page</Button>
                    </InlineStack>
                  </>
                )}
              </ResourceItem>
            );
          }}
        />
      </Card>
      {console.log('showVariantCard in render:', showVariantCard)}
      {showVariantCard && (
 <Card title={`Variants of Product ${variantProductId}`} sectioned>
  <ResourceList
    resourceName={{ singular: 'variant', plural: 'variants' }}
    items={variantData}
    renderItem={(variant) => {
      const { id, title, price } = variant;
      return (
        <ResourceItem id={id}>
          {editingVariantId === id ? (
            <form method="POST" action={variantUpdate.replace('/0', `/${variantProductId}`).replace('/0', `/${id}`)} >
              <input type="hidden" name="_token" value={window.csrfToken} />
              <input type="hidden" name="_method" value="PUT" />
              <input type="hidden" name="id" value={id} />
              <p><strong>ID:</strong> {id}</p>
              <TextField label="Title" name="title" value={editingVariantTitle} onChange={setEditingVariantTitle} required/>
              <input type="hidden" name="title" value={editingVariantTitle} />
              <TextField label="Price" name="price" value={editingVariantPrice} onChange={setEditingVariantPrice} required />
              <input type="hidden" name="price" value={editingVariantPrice} />
              <TextField label="Option1" name="option1" value={editingVariantOption1} onChange={setEditingVariantOption1} required />
              <input type="hidden" name="option1" value={editingVariantOption1} />
              <TextField label="SKU" name="sku" value={editingVariantSku} onChange={setEditingVariantSku} required />
              <input type="hidden" name="sku" value={editingVariantSku} />
              <InlineStack gap="200">
                <Button submit primary>Save</Button>
                <Button onClick={() => setEditingVariantId(null)}>Cancel</Button>
              </InlineStack>
            </form>
          ) : (
            <>
              <h3>{title}</h3>
              <p>Price: {price}</p>
              <InlineStack gap="200">
                <Button onClick={() => {setEditingVariantId(id); setEditingVariantTitle(title); setEditingVariantPrice(price);   setEditingVariantOption1(variant.option1 || ''); setEditingVariantSku(variant.sku || '');}}>Edit</Button>
                <form method="POST" action={variantDelete.replace('/0', `/${variantProductId}`).replace('/0', `/${id}`)}>
                <input type="hidden" name="_token" value={window.csrfToken} />
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="id" value={id} />
                <Button destructive submit>Delete Variant</Button>
              </form>
              </InlineStack>
            </>
          )}
        </ResourceItem>
      );
    }}
  />
  <Button onClick={() => setShowVariantCard(false)}>Close</Button>
  <Button onClick={() => setVariantCreateOpen(true)}>Create Variant</Button>
  {variantCreateOpen && (
        <Card title={`Create Variant for Product ${variantProductId}`} sectioned>
          <form method="POST" action={variantCreate.replace('/0', `/${variantProductId}`)}>
            <input type="hidden" name="_token" value={window.csrfToken} />
            <TextField label="Title" value={editingVariantTitle} onChange={setEditingVariantTitle} required /><input type="hidden" name="title" value={editingVariantTitle} />
            <TextField label="Price" value={editingVariantPrice} onChange={setEditingVariantPrice} required /><input type="hidden" name="price" value={editingVariantPrice} />
            <TextField label="Option1" value={editingVariantOption1} onChange={setEditingVariantOption1} required /><input type="hidden" name="option1" value={editingVariantOption1} />
            <TextField label="SKU" value={editingVariantSku} onChange={setEditingVariantSku} required /><input type="hidden" name="sku" value={editingVariantSku} />
            <InlineStack gap="200">
              <Button submit primary>Create Variant</Button>
              <Button onClick={() => setVariantCreateOpen(false)}>Cancel</Button>
            </InlineStack>
          </form>
        </Card>
      )}
</Card>
)}

       <Card sectioned>
        <Button onClick={() => setShowSoftDelete(!showSoftDelete)}>
          Manage Soft Delete Product
        </Button>
      </Card>
      {showSoftDelete && (
        <Card title="Soft Deleted Products" sectioned>
          <ResourceList
            resourceName={{ singular: 'product', plural: 'products' }}
            items={softDeleteData}
            renderItem={(item) => {
              const { id, title } = item;
              const productId =
                typeof id === 'string'
                  ? id.split('/').pop()
                  : typeof id === 'number'
                  ? id.toString()
                  : null;

              return (
                <ResourceItem id={productId}>
                  <h3>{title}</h3>
                  <InlineStack gap="200">
                    <form method="POST" action={harddelete}>
                      <input type="hidden" name="_token" value={window.csrfToken} />
                      <input type="hidden" name="id" value={productId} />
                      <input type="hidden" name="_method" value="DELETE" />
                      <Button destructive submit>Delete Permanently</Button>
                    </form>
                  </InlineStack>
                </ResourceItem>
              );
            }}
          />
        </Card>
      )}


    </Page>
  );
}