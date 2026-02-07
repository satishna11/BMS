import 'package:flutter/material.dart';

class DashboardScreen extends StatelessWidget {
  const DashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[300],
      body: Row(
        children: [
          // ===== Sidebar =====
          Container(
            width: 220,
            color: Colors.grey[200],
            padding: const EdgeInsets.all(16),
            child: ListView(
              children: [
                sidebarTitle("Dashboard"),
                sidebarSection("Income", ["Add Income", "View Income"]),
                sidebarSection("Expenses", ["Add Expense", "View Expense"]),
                sidebarSection("Budget", ["Add Budget", "View Budget"]),
                sidebarSection("Report", ["View Report"]),
              ],
            ),
          ),

          // ===== Main Dashboard Content =====
          Expanded(
            child: Padding(
              padding: const EdgeInsets.all(24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    "Dashboard",
                    style: TextStyle(fontSize: 26, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 20),

                  // Summary Cards
                  Row(
                    children: [
                      dashboardCard("Total Income", "Rs. 50,000"),
                      const SizedBox(width: 16),
                      dashboardCard("Total Expense", "Rs. 32,000"),
                      const SizedBox(width: 16),
                      dashboardCard("Remaining", "Rs. 18,000"),
                    ],
                  ),

                  const SizedBox(height: 30),

                  // Recent Transactions
                  const Text(
                    "Recent Expenses",
                    style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 12),

                  Expanded(
                    child: Container(
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(16),
                      ),
                      child: ListView(
                        children: [
                          transactionRow("Grocery", "Rs. 1,200", "Jan 10"),
                          transactionRow("Bus Fare", "Rs. 200", "Jan 11"),
                          transactionRow("Shopping", "Rs. 3,000", "Jan 12"),
                          transactionRow("Education", "Rs. 5,000", "Jan 13"),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ===== Sidebar Helpers =====
  Widget sidebarTitle(String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
    );
  }

  Widget sidebarSection(String title, List<String> items) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 12),
        Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
        ...items.map(
          (e) => Padding(
            padding: const EdgeInsets.only(left: 12, top: 6),
            child: Text(e),
          ),
        ),
      ],
    );
  }

  // ===== Dashboard Cards =====
  Widget dashboardCard(String title, String value) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(16),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(title, style: const TextStyle(color: Colors.grey)),
            const SizedBox(height: 8),
            Text(
              value,
              style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
          ],
        ),
      ),
    );
  }

  // ===== Transaction Row =====
  static Widget transactionRow(String title, String amount, String date) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [Text(title), Text(amount), Text(date)],
      ),
    );
  }
}
