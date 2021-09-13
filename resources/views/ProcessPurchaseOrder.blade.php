<us:ProcessPurchaseOrder
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:us="http://www.ussco.com/oagis/0"
  xmlns:oa="http://www.openapplications.org/oagis/9" releaseID="1.0" systemEnvironmentCode="{{ $system_environment_code }}" languageCode="en-US">
  <us:ApplicationArea>
    <oa:Sender>
      <oa:LogicalID>{{ $trading_partners_unique_id }}</oa:LogicalID>
    </oa:Sender>
    <us:ReceiverId>{{ $essendant_inc_unique_id }}</us:ReceiverId>
    <oa:CreationDateTime>{{ $date_time_created }}</oa:CreationDateTime>
    <oa:BODID>{{ $document_control_number }}</oa:BODID>
  </us:ApplicationArea>
  <us:DataArea>
    <oa:Process>
      <oa:ActionCriteria>
        <oa:ChangeStatus>
          <oa:Code>{{ $action_code }}</oa:Code>
        </oa:ChangeStatus>
      </oa:ActionCriteria>
    </oa:Process>
    <us:PurchaseOrder
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xmlns:us="http://www.ussco.com/oagis/0"
      xmlns:oa="http://www.openapplications.org/oagis/9">
      <us:PurchaseOrderHeader>
        <oa:DocumentID>
          <oa:ID>{{ $purchase_order_number }}</oa:ID>
        </oa:DocumentID>
        <oa:AlternateDocumentID>
          <oa:ID>{{ $purchase_order_number }}</oa:ID>
        </oa:AlternateDocumentID>
        <oa:DocumentDateTime>{{ $date_time_created }}</oa:DocumentDateTime>
        <oa:DocumentReference type="{{ $reference_tag }}">
          <oa:DocumentID>
            <oa:ID>{{ $reference_data }}</oa:ID>
          </oa:DocumentID>
          <oa:SalesOrderReference>
            <oa:DocumentID>
              <oa:ID>Essendant Inc Order Number</oa:ID>
            </oa:DocumentID>
          </oa:SalesOrderReference>
        </oa:DocumentReference>
        <oa:SupplierParty>
          <oa:Name>Supplier Party Name</oa:Name>
        </oa:SupplierParty>
        <oa:ShipToParty>
          <oa:PartyIDs>
            <oa:ID>Ship To Account Number</oa:ID>
          </oa:PartyIDs>
          <oa:Name>Ship To Name</oa:Name>
          <oa:Location>
            <oa:Address type="Ship To Type Indicator">
              <oa:LineOne>Ship To Address Line 1</oa:LineOne>
              <oa:LineTwo>Ship To Address Line 2</oa:LineTwo>
              <oa:LineThree>Ship To Address Line 3</oa:LineThree>
              <oa:CityName>Ship To City</oa:CityName>
              <oa:CountrySubDivisionCode>Ship To State</oa:CountrySubDivisionCode>
              <oa:PostalCode>Ship To Zip Code</oa:PostalCode>
            </oa:Address>
            <oa:Address type="Ship To Zip Code Override Indicator">
              <oa:PostalCode>Ship To Zip Code Override</oa:PostalCode>
            </oa:Address>
          </oa:Location>
        </oa:ShipToParty>
        <us:ShippingLabel>
          <us:SpecialInstructions sequence="1">Special Instructions Line 1</us:SpecialInstructions>
          <us:SpecialInstructions sequence="2">Special Instructions Line 2</us:SpecialInstructions>
          <us:ShippingInstructions sequence="1">Shipping Instructions Line 1</us:ShippingInstructions>
          <us:ShippingInstructions sequence="2">Shipping Instructions Line 2</us:ShippingInstructions>
          <us:ShippingInstructions sequence="3">Shipping Instructions Line 3</us:ShippingInstructions>
          <us:ShippingInstructions sequence="4">Shipping Instructions Line 4</us:ShippingInstructions>
          <us:ShippingInstructions sequence="5">Shipping Instructions Line 5</us:ShippingInstructions>
          <us:ShippingInstructions sequence="6">Shipping Instructions Line 6</us:ShippingInstructions>
          <us:CustomerInstructions sequence="1">Dealer Instructions Line 1</us:CustomerInstructions>
          <us:CustomerInstructions sequence="2">Dealer Instructions Line 2</us:CustomerInstructions>
          <us:CustomerInstructions sequence="3">Dealer Instructions Line 3</us:CustomerInstructions>
          <us:CustomerInstructions sequence="4">Dealer Instructions Line 4</us:CustomerInstructions>
          <us:CustomerInstructions sequence="5">Dealer Instructions Line 5</us:CustomerInstructions>
          <us:CustomerInstructions sequence="6">Dealer Instructions Line 6</us:CustomerInstructions>
          <us:LabelOverrideFormat>Ship Label Format Override</us:LabelOverrideFormat>
          <us:BarCode>Bar Code Data</us:BarCode>
        </us:ShippingLabel>
        <us:ShippingIndicator>Order Type Indicator</us:ShippingIndicator>
        <us:DealerRouteCode>Route Data</us:DealerRouteCode>
        <us:DealerRouteID>Route Tag</us:DealerRouteID>
        <us:FacilityID>Facility Override</us:FacilityID>
        <us:RejectDuplicateIndicator>Reject Duplicates Indicator</us:RejectDuplicateIndicator>
        <us:WrapLabelNumber>Wrap Number in a Wrap and Label Ship to Type</us:WrapLabelNumber>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
      </us:PurchaseOrderHeader>
      <us:PurchaseOrderLine>
        <oa:LineNumber>Detail Line Number</oa:LineNumber>
        <us:Item>
          <oa:ItemID>
            <oa:ID>Essendant Inc Item Number</oa:ID>
          </oa:ItemID>
        </us:Item>
        <oa:Quantity unitCode="Unit of Measure">Quantity Ordered</oa:Quantity>
        <oa:UnitPrice>
          <oa:Amount currencyID="USD">Price</oa:Amount>
          <oa:PerQuantity />
        </oa:UnitPrice>
        <us:ADOTCode>ADOT Code</us:ADOTCode>
        <us:BackOrderCode>Backorder Code</us:BackOrderCode>
        <us:PackingSlip>
          <us:LineText sequence="1">Line Text</us:LineText>
          <us:LineText sequence="2">Line Text</us:LineText>
        </us:PackingSlip>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
        <us:PassThruData qualifier="Pass Thru Data Qualifier">Pass Thru Data</us:PassThruData>
      </us:PurchaseOrderLine>
    </us:PurchaseOrder>
  </us:DataArea>
</us:ProcessPurchaseOrder>
