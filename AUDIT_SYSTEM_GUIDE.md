# System Activity Monitor - Admin Guide

## Overview

The System Activity Monitor provides comprehensive real-time monitoring of all activities happening on your drilling dashboard website. Think of it as your "security camera" for the system - you can see everything that happens, when it happens, and who did it.

## Key Features

### 🔍 **Complete Visibility**
- Track ALL changes to products, owners, sold products, users, and more
- See exactly what changed, from what value to what value
- Monitor user activities in real-time
- Track login/logout events and failed login attempts

### 📊 **Comprehensive Dashboard**
- Visual charts showing daily activity trends
- Event type breakdown (created, updated, deleted)
- Most active users and models
- Statistics for today, this week, and this month

### ⚡ **Real-time Monitoring**
- Live activity feed that updates automatically
- See new activities as they happen
- Real-time alerts for important events

### 🔒 **Security Features**
- Sensitive data (passwords) are automatically excluded from logs
- IP address and browser tracking for security auditing
- Failed login attempt monitoring
- Complete audit trail for compliance

## What Gets Monitored

### Models Tracked:
- **Products**: All product changes (creation, updates, deletions)
- **Owners**: Customer information changes
- **Sold Products**: Sales record modifications
- **Users**: User account changes (excluding passwords)
- **Product Categories**: Category modifications
- **Contact Messages**: New messages and status changes
- **Pending Changes**: Employee edit requests
- **Authentication**: Login/logout events

### Information Captured:
- **Who**: User who made the change
- **What**: Exact fields that changed
- **When**: Precise timestamp
- **Where**: IP address and location
- **How**: Browser and device information
- **Why**: URL and context of the change

## How to Use

### Accessing the Monitor

1. **Dashboard View**: Go to `Admin > System Monitor > Dashboard`
   - Overview of recent activity
   - Charts and statistics
   - Quick insights

2. **Activity Log**: Go to `Admin > System Monitor > Activity Log`
   - Detailed list of all activities
   - Advanced filtering options
   - Real-time monitoring

### Dashboard Features

**Statistics Cards:**
- Total Events: All-time activity count
- Today: Activities in the last 24 hours
- This Week: Activities since Monday
- This Month: Activities since the 1st

**Charts:**
- Daily Activity: 7-day trend line
- Event Types: Pie chart of action types
- Active Models: Which parts of the system are most used
- Active Users: Who's doing the most work

### Activity Log Features

**Filtering Options:**
- **Date Range**: Filter by specific time periods
- **Event Type**: Show only creates, updates, or deletes
- **Model Type**: Focus on specific parts (products, owners, etc.)
- **User**: See activities by specific users
- **Search**: Find specific changes by content

**Real-time Mode:**
- Click "Real-time" button to enable live monitoring
- New activities appear immediately with yellow highlighting
- Automatic refresh every 3 seconds
- Perfect for monitoring ongoing work

**Export Feature:**
- Click "Export" to download filtered results as CSV
- Include date ranges and filters in export
- Perfect for compliance reporting

### Viewing Change Details

**Change Inspection:**
- Click "View Changes" to see exactly what changed
- Side-by-side comparison of old vs new values
- Color coding: Red for old, Green for new
- JSON format for technical details

**Related Activity:**
- Click on any log entry to see full details
- View related changes to the same record
- Timeline of all activities on specific items

## Common Use Cases

### 1. **Employee Monitoring**
- See what employees are doing in real-time
- Track productivity and work patterns
- Identify training needs

### 2. **Security Auditing**
- Monitor login/logout patterns
- Track failed login attempts
- Identify suspicious activities
- Audit trail for compliance

### 3. **Data Integrity**
- See who changed what and when
- Track down sources of data issues
- Verify accuracy of changes
- Rollback guidance

### 4. **Business Intelligence**
- Understand system usage patterns
- Identify popular features
- Track user engagement
- Performance metrics

### 5. **Compliance Reporting**
- Generate audit reports for regulators
- Prove data handling compliance
- Track access controls
- Document change management

## Security & Privacy

**What's Protected:**
- Passwords are NEVER logged
- Sensitive fields are automatically excluded
- User tokens and secrets are filtered out
- Only administrators can access audit logs

**Data Retention:**
- All activities are logged indefinitely
- Can be purged manually if needed
- Export before purging for archival

**Access Control:**
- Only admin users can view audit logs
- Employees cannot see monitoring data
- Secure access through admin authentication

## Tips for Effective Monitoring

### Daily Monitoring:
1. Check the dashboard each morning
2. Review yesterday's activities
3. Look for unusual patterns
4. Follow up on high-activity periods

### Weekly Reviews:
1. Export weekly activity reports
2. Analyze user productivity
3. Check for security anomalies
4. Review system usage trends

### Monthly Analysis:
1. Generate monthly compliance reports
2. Analyze growth patterns
3. Identify system optimization opportunities
4. Plan capacity and training needs

### Real-time Monitoring:
1. Enable during important operations
2. Monitor during employee training
3. Watch during system migrations
4. Track during peak business hours

## Troubleshooting

**Common Issues:**

1. **No New Logs Appearing**
   - Check if users are actually making changes
   - Verify audit logging is enabled on models
   - Check browser console for JavaScript errors

2. **Real-time Not Working**
   - Refresh the page
   - Check internet connection
   - Disable browser ad blockers

3. **Export Not Working**
   - Check file download permissions
   - Try smaller date ranges
   - Clear browser cache

**Performance Tips:**
- Use date filters for large datasets
- Limit real-time monitoring duration
- Export in smaller chunks for large reports

## Advanced Features

### API Access:
The audit logs can be accessed programmatically for integration with other systems or automated reporting.

### Custom Alerting:
Set up notifications for specific events or patterns (future enhancement).

### Data Analysis:
Export data for analysis in Excel, business intelligence tools, or custom applications.

---

**Remember**: This system gives you complete visibility into your drilling dashboard operations. Use it responsibly to improve security, compliance, and operational efficiency.

For technical support or questions about specific activities, contact your system administrator.
