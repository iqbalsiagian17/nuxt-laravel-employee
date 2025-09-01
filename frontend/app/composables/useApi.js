export const useApi = () => {
  const baseURL = 'http://localhost:8000/api'

  return async (url, options = {}) => {
    const token = localStorage.getItem('token')
    const headers = {
      Accept: 'application/json',    // 🔑 WAJIB
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {})
    }

    const res = await fetch(baseURL + url, {
      ...options,
      headers,
      body: options.body ? JSON.stringify(options.body) : null
    })

    if (!res.ok) {
      const err = await res.json().catch(() => ({}))
      throw new Error(err.message || 'API Error')
    }

    return await res.json()
  }
}
