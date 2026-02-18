import 'package:flutter/material.dart';

class DashboardScreen extends StatelessWidget {
  const DashboardScreen({super.key});

  // ===== Sidebar Menu Data =====
  static final Map<String, Map<String, String>> sidebarMenu = {
    "Income": {"Add Income": "/add-income", "View Income": "/view-income"},
    "Expenses": {
      "Add Expense": "/add-expense",
      "View Expense": "/view-expense",
    },
    "Budget": {"Add Budget": "/add-budget", "View Budget": "/view-budget"},
    "Report": {"View Report": "/report"},
  };

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
                sidebarTitle(context),
                ...sidebarMenu.entries.map(
                  (section) =>
                      sidebarSection(context, section.key, section.value),
                ),
              ],
            ),
          ),

          // ===== Main Content =====
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
                        children: const [
                          TransactionRow("Grocery", "Rs. 1,200", "Jan 10"),
                          TransactionRow("Bus Fare", "Rs. 200", "Jan 11"),
                          TransactionRow("Shopping", "Rs. 3,000", "Jan 12"),
                          TransactionRow("Education", "Rs. 5,000", "Jan 13"),
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

  // ===== Sidebar Widgets =====

  Widget sidebarTitle(BuildContext context) {
    return ListTile(
      title: const Text(
        "Dashboard",
        style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
      ),
      onTap: () {
        // ⚡ Fixed: '/' does not exist, use '/dashboard'
        Navigator.pushReplacementNamed(context, '/dashboard');
      },
    );
  }

  Widget sidebarSection(
    BuildContext context,
    String title,
    Map<String, String> items,
  ) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 12),
        Padding(
          padding: const EdgeInsets.symmetric(vertical: 6),
          child: Text(
            title,
            style: const TextStyle(fontWeight: FontWeight.bold),
          ),
        ),
        ...items.entries.map(
          (entry) => ListTile(
            dense: true,
            contentPadding: const EdgeInsets.only(left: 16),
            title: Text(entry.key),
            onTap: () {
              // ⚡ Navigate to route safely
              Navigator.pushNamed(context, entry.value);
            },
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
}

// ===== Transaction Row =====

class TransactionRow extends StatelessWidget {
  final String title;
  final String amount;
  final String date;

  const TransactionRow(this.title, this.amount, this.date, {super.key});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [Text(title), Text(amount), Text(date)],
      ),
    );
  }
}
