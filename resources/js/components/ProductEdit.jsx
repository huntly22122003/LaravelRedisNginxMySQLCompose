// ProductEdit.jsx
import React from 'react';
import { useParams } from 'react-router-dom';
import { TextField, Button } from '@shopify/polaris';

export default function ProductEdit() {
  const { id } = useParams();

  return (
    <div>
      <h3>Edit Product {id}</h3>
      <form method="POST" action={`/products/${id}`}>
        <input type="hidden" name="_token" value={window.csrfToken} />
        <input type="hidden" name="_method" value="PUT" />
        <TextField label="Title" name="title" required />
        <TextField label="Price" name="price" required />
        <Button submit primary>Save</Button>
      </form>
    </div>
  );
}