// resources/js/shopify.jsx
import React from 'react'
import { createRoot } from 'react-dom/client'
import { AppProvider, Page, Card, Button } from '@shopify/polaris'
import '@shopify/polaris/build/esm/styles.css'

function App() {
  return (
    <AppProvider i18n={{}}>
      <Page title="Shopify App">
        <Card sectioned>
          <p>Polaris chạy OK 🎉</p>
          <Button primary>Test button</Button>
        </Card>
      </Page>
    </AppProvider>
  )
}

createRoot(document.getElementById('app')).render(<App />)
