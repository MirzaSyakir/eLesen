# Lesen Saya - User License Management

## Overview
The "Lesen Saya" (My Licenses) feature allows users to view their approved licenses in a dedicated page. This feature provides a comprehensive view of all approved licenses with detailed information and management capabilities.

## Features

### 1. License Overview
- **Statistics Dashboard**: Shows total licenses, active licenses, and expired licenses
- **License Cards**: Each license is displayed in a modern card format with:
  - License number and type
  - Business name and address
  - Approval date and expiry date
  - License status (Active/Expired)
  - Detailed information grid

### 2. License Information Display
Each license card shows:
- **License Number**: Unique identifier for the license
- **License Type**: Type of business license
- **Business Details**: Name and address of the business
- **Approval Information**: Date when the license was approved
- **Expiry Information**: Date when the license expires
- **Status**: Active or Expired status
- **Additional Details**: Processing type, building type, premise size, worker count

### 3. User Interface Features
- **Responsive Design**: Works on desktop and mobile devices
- **Modern UI**: Clean, professional design with purple theme
- **Loading States**: Smooth loading experience
- **Empty State**: Helpful message when no licenses are available
- **Pagination**: Handles large numbers of licenses efficiently

### 4. Navigation
- **Back to Dashboard**: Easy navigation back to main dashboard
- **Apply for New License**: Quick access to apply for new licenses
- **Action Buttons**: View details and download options for each license

## Files Created/Modified

### New Files
1. **`page/my-licenses.php`** - Main user interface for viewing licenses
2. **`api/permohonan/approved_licenses.php`** - API endpoint for fetching approved licenses
3. **`database/migration_add_license_columns.sql`** - Database migration script

### Modified Files
1. **`database/elesen.sql`** - Updated schema with new license columns
2. **`page/dashboard.php`** - Already has link to "Lesen Saya" in quick actions

## Database Schema Updates

### New Columns Added to `license_applications` table:
- `license_number` - Unique license identifier
- `approved_at` - Timestamp when license was approved
- `expiry_date` - Date when license expires
- `license_fee` - Fee amount for the license
- `payment_status` - Payment status (pending/paid/overdue)
- `payment_date` - Date when payment was made
- `approved_by` - Admin who approved the license
- `approval_remarks` - Remarks from approval process

## API Endpoints

### GET `/api/permohonan/approved_licenses.php`
Fetches approved licenses for the authenticated user.

**Parameters:**
- `page` (optional): Page number for pagination (default: 1)
- `limit` (optional): Number of licenses per page (default: 10, max: 50)

**Response:**
```json
{
  "status": 200,
  "data": {
    "licenses": [
      {
        "id": 1,
        "application_number": "LPT-2024-001",
        "license_number": "LPT-2024-001",
        "license_type": "Lesen Perniagaan Premis Tetap",
        "business_name": "Kedai Runcit Ahmad",
        "business_address": "No. 123, Jalan Besar...",
        "approved_at": "2024-01-10 14:20:00",
        "expiry_date": "2025-01-10",
        "license_fee": "100.00",
        "payment_status": "paid",
        "payment_date": "2024-01-10 14:20:00"
      }
    ],
    "pagination": {
      "current_page": 1,
      "total_pages": 1,
      "total_count": 1,
      "limit": 10,
      "has_next": false,
      "has_prev": false
    }
  }
}
```

## Installation Instructions

### 1. Database Setup
Run the migration script to add new columns:
```sql
-- Execute the migration script
source database/migration_add_license_columns.sql;
```

### 2. File Deployment
Ensure all new files are uploaded to the server:
- `page/my-licenses.php`
- `api/permohonan/approved_licenses.php`

### 3. Access
Users can access "Lesen Saya" through:
- Dashboard → Quick Actions → "Lesen Saya"
- Direct URL: `/page/my-licenses.php`

## Usage

### For Users
1. **Login** to the eLesen system
2. **Navigate** to Dashboard
3. **Click** "Lesen Saya" in the Quick Actions section
4. **View** all approved licenses with detailed information
5. **Use** pagination to navigate through multiple licenses
6. **Click** action buttons to view details or download licenses

### For Developers
1. **API Integration**: Use the approved_licenses.php endpoint to fetch user licenses
2. **Customization**: Modify the UI by editing the CSS in my-licenses.php
3. **Extending**: Add new features like license renewal or payment processing

## Future Enhancements

### Planned Features
1. **License Download**: Generate and download PDF license certificates
2. **License Renewal**: Allow users to renew expiring licenses
3. **Payment Integration**: Online payment for license fees
4. **Notifications**: Email/SMS notifications for expiring licenses
5. **License History**: Complete history of all license applications

### Technical Improvements
1. **Caching**: Implement caching for better performance
2. **Search/Filter**: Add search and filter capabilities
3. **Export**: Allow users to export license data
4. **Mobile App**: Native mobile application support

## Security Considerations

1. **Authentication**: All API calls require valid session tokens
2. **Authorization**: Users can only view their own licenses
3. **Data Validation**: All input data is validated and sanitized
4. **SQL Injection**: Prepared statements prevent SQL injection attacks
5. **Session Management**: Secure session handling with expiration

## Troubleshooting

### Common Issues
1. **No licenses showing**: Check if user has approved applications
2. **API errors**: Verify database connection and table structure
3. **Styling issues**: Ensure Bootstrap and custom CSS are loaded
4. **Session errors**: Check if user is properly logged in

### Debug Steps
1. Check browser console for JavaScript errors
2. Verify API endpoint is accessible
3. Confirm database migration was successful
4. Test with different user accounts

## Support

For technical support or feature requests, please contact the development team or create an issue in the project repository. 