# 🤝 Contributing to Apriori Data Mining System

Thank you for your interest in contributing! This document provides guidelines and instructions for contributing to this project.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How to Contribute](#how-to-contribute)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Pull Request Process](#pull-request-process)

## 📜 Code of Conduct

We are committed to providing a welcoming and inclusive environment for everyone.

### Expected Behavior

✅ **Do:**
- Use welcoming and inclusive language
- Respect differing viewpoints
- Accept constructive criticism
- Focus on what's best for the community

❌ **Don't:**
- Use inappropriate language
- Engage in trolling or harassment
- Publish others' private information

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.1 (aktifkan ekstensi mbstring, openssl, zip)
- MySQL >= 5.7
- Composer
- Git

### Fork & Clone

1. Fork the repository on GitHub
2. Clone your fork:
```bash
git clone https://github.com/YOUR_USERNAME/apriori.git
cd apriori
```

3. Add upstream remote:
```bash
git remote add upstream https://github.com/wokding/apriori.git
```

4. Install dependencies:
```bash
composer install
```

## 💡 How to Contribute

We welcome:
- 🐛 Bug fixes
- ✨ New features
- 📝 Documentation improvements
- 🎨 UI/UX enhancements
- ⚡ Performance optimizations

## 🔄 Development Workflow

### 1. Create a Branch

```bash
# For features
git checkout -b feature/amazing-feature

# For bug fixes
git checkout -b fix/bug-description
```

### 2. Commit Changes

Use meaningful commit messages:

```bash
git commit -m "feat: add export to Excel"
git commit -m "fix: correct support calculation"
git commit -m "docs: update installation guide"
```

### 3. Push & Create PR

```bash
git push origin feature/amazing-feature
```

Then create a Pull Request on GitHub.

## 📏 Coding Standards

### PHP Style

```php
<?php
/**
 * Controller documentation
 */
class MyController extends CI_Controller
{
    /**
     * Method documentation
     */
    public function index()
    {
        // Code here
    }
}
```

### Key Points

✅ **Do:**
- Use descriptive variable names
- Add PHPDoc comments
- Keep functions focused
- Follow CodeIgniter conventions

❌ **Don't:**
- Use short PHP tags
- Hard-code values
- Leave commented code

## 📤 Pull Request Process

### Before Submitting

- [ ] Code follows style guidelines
- [ ] Documentation updated
- [ ] Self-review completed
- [ ] No merge conflicts

### PR Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation

## Testing
How did you test?

## Screenshots
If applicable
```

## 🐛 Issue Reporting

### Bug Report

```markdown
**Describe the bug**
Clear description

**To Reproduce**
Steps to reproduce

**Expected behavior**
What you expected

**Environment:**
- OS, PHP version, Browser
```

## 📞 Questions?

- 💬 [GitHub Discussions](https://github.com/wokding/apriori/discussions)
- 🐛 [Issue Tracker](https://github.com/wokding/apriori/issues)

## 📄 License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

<p align="center">
  <strong>Thank you for contributing! 🎉</strong>
</p>
